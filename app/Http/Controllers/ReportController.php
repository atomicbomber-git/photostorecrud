<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Invoice;
use Jenssegers\Date\Date;

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

        $formatted_start_date = $start_date->format("Y-m-d H:i:s");
        $formatted_end_date = $end_date->addDay()->format("Y-m-d H:i:s");

        return Invoice::where("is_finished", 1)
            ->whereBetween("created_at", [$formatted_start_date, $formatted_end_date])
            ->get()->count();
    } 
}
