<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\InvoiceItem;

class InvoiceItemController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            "quantity" => "required|integer|min:1"
        ])->validate();

        $invoice_item = InvoiceItem::where("item_id", $request->item_id)->first();

        if ( ! $invoice_item) {
            InvoiceItem::create([
                "quantity" => $request->quantity,
                "item_id" => $request->item_id,
                "invoice_id" => $request->invoice_id
            ]);
        }
        else {
            $invoice_item->quantity += $request->quantity;
            $invoice_item->save();
        }

        return back();
    }

    public function updateQuantity(Request $request, $id)
    {
        Validator::make($request->all(), [
            "update_quantity" => "required|integer|min:1"
        ], 
        [
            "update_quantity.*" => "Nilai kolom jumlah wajib berupa bilangan bulat dan bernilai lebih dari 0 (nol)."
        ]
        )->validate();

        InvoiceItem::find($id)->update(["quantity" => $request->update_quantity]);
        return back();
    }

    public function destroy(Request $request, $id)
    {
        InvoiceItem::find($id)->delete();
        return back();
    }
}
