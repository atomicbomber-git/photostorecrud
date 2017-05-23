<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = null;
        if (Auth::user()->isClerk())
            $invoices = Invoice::where("user_id", Auth::id())->get();
        else
            $invoices = Invoice::get();

        return view("invoice.index", [
            "invoices" => $invoices
        ]);
    }

    public function show(Request $request, Invoice $invoice)
    {
        return view("invoice.show", [
            "invoice" => $invoice
        ]);
    }

    public function create()
    {
        return view("invoice.create");
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            "customer_name" => "string",
            "customer_phone" => "string",
            "customer_addess" => "string"
        ])->validate();

        Invoice::create(array_merge($request->all(), ["user_id" => Auth::id()]));

        return redirect()
            ->route("invoice.index")
            ->with("message", "Invoice baru berhasil dibuat");
    }
}
