<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function dashboard()
    {
        return view("dashboard");
    }

    public function test()
    {
        return view("test");
    }

    public function upload(Request $request)
    {
        $path = $request->image->store("public/images");
        return response($path);
    }
}
