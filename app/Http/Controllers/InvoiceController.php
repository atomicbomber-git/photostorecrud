<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Invoice;
use App\InvoiceItem;
use App\Item;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $whereRules = ["is_finished" => 0];

        /* A clerk can only access his own invoices */
        if (Auth::user()->isClerk())
            $whereRules["user_id"] = Auth::id();

        $invoices = Invoice::where($whereRules)
            ->orderBy("updated_at", "DESC")
            ->get();

        return view("invoice.index", [
            "invoices" => $invoices
        ]);
    }

    public function finishedIndex()
    {
        $whereRules = ["is_finished" => 1];

        /* A clerk can only access his own invoices */
        if (Auth::user()->isClerk())
            $whereRules["user_id"] = Auth::id();

        $invoices = Invoice::where($whereRules)
            ->orderBy("updated_at", "DESC")
            ->get();

        return view("invoice.finished_index", [
            "invoices" => $invoices
        ]);
    }

    public function show(Request $request, Invoice $invoice)
    {
        $invoiceitems = $invoice->invoiceitems;

        $total = $invoiceitems->reduce(function ($carry, $invoice_item) {
            return $carry + ($invoice_item->quantity * $invoice_item->item->price);
        }, 0);

        return view("invoice.show", [
            "invoice" => $invoice,
            "items" => Item::get(["id", "name"]),
            "invoiceitems" => $invoiceitems,
            "total" => "Rp. " . number_format($total, 2, ",", ".")
        ]);
    }

    public function create()
    {
        return view("invoice.create");
    }

    public function store(Request $request)
    {
        $this->validateInvoiceData($request->all());
        Invoice::create(array_merge($request->all(), ["user_id" => Auth::id()]));

        return redirect()
            ->route("invoice.index")
            ->with("message", "Invoice baru berhasil dibuat.");
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->validateInvoiceData($request->all());
        $invoice->update($request->all());
        return back()->with("message", "Data invoice berhasil diubah.");
    }

    public function finish(Request $request, Invoice $invoice)
    {
        if ( ! $invoice->invoiceitems->count()) {
            return redirect()
                ->route("invoice.show", ["id" => $invoice->id])
                ->withErrors(["invoice_item" => "Invoice masih kosong. Minimal terdapat satu item untuk setiap invoice"]);
        }

        DB::beginTransaction();

        try {
            foreach ($invoice->invoiceitems as $invoiceitem) {
                if ($invoiceitem->quantity > $invoiceitem->item->stock) {
                    throw new \Exception();
                }

                $invoiceitem->item->stock -= $invoiceitem->quantity;
                $invoiceitem->item->save();

                /* Copy name from item records to invoiceitem records */
                $invoiceitem->name = $invoiceitem->item->name;
                $invoiceitem->price = $invoiceitem->item->price;
                $invoiceitem->save();
            }
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with("message", "Jumlah item pesanan melebihi stock yang ada, mohon perbaiki invoice Anda.");
        }
        DB::commit();

        /* Mark invoice as finished */
        $invoice->setAsFinished();
        return redirect()->route("invoice.index");
    }

    public function pdf(Request $request, Invoice $invoice)
    {
        return PDF::loadView("invoice.pdf", ["invoice" => $invoice])
            ->setPaper("a5", "landscape")
            ->stream("invoice.pdf");
    }

    private function validateInvoiceData($invoiceData)
    {
        Validator::make($invoiceData, [
            "customer_name" => "string",
            "customer_phone" => "string",
            "customer_addess" => "string"
        ])->validate();
    }
}
