<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Invoice extends Model
{
    public function localDate()
    {
        $date = new Date($this->created_at);
        return $date->format('l, j F Y H:i');
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

    protected $fillable = [
        "customer_name", "customer_phone", "customer_address", "user_id"
    ];
}
