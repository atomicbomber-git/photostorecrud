<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->hasOne("App\Category");
    }

    public function formattedPrice()
    {
        return "Rp. " . number_format($this->price, 2, ",", ".");
    }


    protected $fillable = ["name", "stock", "price", "description", "category_id", "image"];
}
