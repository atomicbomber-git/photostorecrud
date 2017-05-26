<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Invoice;
use Jenssegers\Date\Date;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view("report.index", [
            "today" => Date::now()->format("d-m-Y")
        ]);
    }

    public function pdf(Request $request)
    {
        Validator::make($request->all(), [
            "start_date" => "required|date_format:d-m-Y",
            "end_date" => "required|date_format:d-m-Y"
        ])->validate();

        $start_date = new Date($request->start_date);
        $end_date = new Date($request->end_date);

        if ($start_date->gt($end_date)) {
            $message = "Tanggal mulai tidak boleh lebih dari tanggal akhir";
            return back()->withErrors([
                "start_date" => $message,
                "end_date" => $message
            ]);
        }

        $formatted_start_date = $start_date->format("Y-m-d H:i:s");
        $formatted_end_date = $end_date->addDay()->format("Y-m-d H:i:s");

        $invoices = Invoice::where("is_finished", 1)
            ->whereBetween("transaction_date", [$formatted_start_date, $formatted_end_date])
            ->get();

        $grand_total = $invoices->reduce(function ($carry, $invoice) {
            return $carry + $invoice->finalSum();
        }, 0);

        $end_date->subDay();

        return PDF::loadView("report.pdf", ["grand_total" => $grand_total, "start_date" => $start_date, "end_date" => $end_date,"invoices" => $invoices])
            ->stream();
    } 
}
