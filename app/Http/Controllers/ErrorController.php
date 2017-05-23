<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function unauthorized()
    {
        return response()->view("error.403", [], 403);
    }

    public function notFound()
    {

    }
}
