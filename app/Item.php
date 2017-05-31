<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function category()
    {
        return $this->belongsTo("App\Category");
    }

    public function invoiceItems()
    {
        return $this->hasMany("App\InvoiceItem");
    }

    public function formattedPrice()
    {
        return "Rp. " . number_format($this->price, 2, ",", ".");
    }

    protected $fillable = ["name", "stock", "price", "description", "category_id", "image"];
}
