<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    public function invoice()
    {
        return $this->belongsTo("App\Invoice");
    }

    public function item()
    {
        return $this->belongsTo("App\Item");
    }

    public function formattedSubtotal()
    {
        return "Rp. " . number_format($this->item->price * $this->quantity, 2, ",", ".");;
    }

    protected $fillable = [
        "quantity", "item_id", "invoice_id"
    ];
}
