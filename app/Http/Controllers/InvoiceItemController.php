<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\InvoiceItem;
use App\Item;

class InvoiceItemController extends Controller
{
    public function store(Request $request, $invoice_id)
    {
        $stock = Item::find($request->item_id)->stock;
        $invoice_item = InvoiceItem::where(["item_id" => $request->item_id, "invoice_id" => $invoice_id])->first();
        $old_quantity = $invoice_item ? $invoice_item->quantity : 0;
        $max = $stock - $old_quantity;

        Validator::make($request->all(),
            [ "quantity" => "required|integer|min:1|max:$max" ],
            [ "quantity.max" => "Jumlah item yang terdapat pada invoice tidak dapat berjumlah lebih dari stock item yang ada, yaitu $stock." ]
        )->validate();

        if ( ! $invoice_item) {
            InvoiceItem::create([
                "quantity" => $request->quantity,
                "item_id" => $request->item_id,
                "invoice_id" => $invoice_id
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
        $invoice_item = InvoiceItem::find($id);
        $stock = $invoice_item->item->stock;

        Validator::make($request->all(), 
            [ "update_quantity" => "required|integer|min:1|max:$stock" ], 
            [
                "update_quantity.min" => "Nilai kolom jumlah wajib berupa bilangan bulat dan bernilai lebih dari 0 (nol).",
                "update_quantity.max" => "Nilai kolom jumlah tidak dapat berjumlah lebih dari stock item yang ada, yaitu :max." 
            ]
        )->validate();

        $invoice_item->update(["quantity" => $request->update_quantity]);
        return back();
    }

    public function destroy(Request $request, $id)
    {
        InvoiceItem::find($id)->delete();
        return back();
    }
}
