<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function validateLogin(Request $request)
    {
        $error_messages = [
            "required" => "Kolom ini wajib diisi!"
        ];

        return Validator::make($request->all(), [
            $this->username() => "required|string",
            "password" => "required|string"
        ], $error_messages)->validate();
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/dashboard";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info("Trying...");
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return "username";
    }
}
