<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Invoice extends Model
{
    public function localDatetime()
    {
        $date = new Date($this->transaction_date);
        return $date->format('l, j F Y H:i');
    }

    public function localDate()
    {
        $date = new Date($this->transaction_date);
        return $date->format('l, j F Y');
    }

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function invoiceitems()
    {
        return $this->hasMany("App\InvoiceItem");
    }

    public function setAsFinished()
    {
        $this->is_finished = 1;
        $this->save();
    }

    public function setAsUnfinished()
    {
        $this->is_finished = 0;
        $this->save();
    }

    public function finalSum()
    {
        $total = $this->invoiceitems->reduce(function ($carry, $invoice_item) {
            return $carry + ($invoice_item->quantity * $invoice_item->price);
        }, 0);

        return $total - $this->discount;
    }

    public function temporarySum() {
        $total = $this->invoiceitems->reduce(function ($carry, $invoice_item) {
            return $carry + ($invoice_item->quantity * $invoice_item->item->price);
        }, 0);

        return $total - $this->discount;
    }

    public function code()
    {
        return $this->created_at->format("YmdHis") . $this->id;
    }

    protected $fillable = [
        "customer_name", "customer_phone", "customer_address", "user_id", "transaction_date",
        "discount"
    ];

    protected $dates = [
        "created_at", "updated_at", "transaction_date"
    ];
}
