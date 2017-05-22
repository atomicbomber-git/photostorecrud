<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("user.index", [
            "users" => User::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route("register");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("user.edit", [
            "user" => User::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        /* 
            Prevent admins from demoting themselves.
            The current user is presumably admin since only admins can modify another
            user's data
        */
        if (Auth::id() === $user->id) {
            if ($request->has("privilege") && ($request->get("privilege") !== Auth::user()->privilege)) {
                return redirect()
                    ->route("user.index")
                    ->withErrors(["privilege" => "Pengguna tidak diizinkan untuk mengubah statusnya sendiri."]);
            }
        }

        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:8|max:255'
        ];

        $modify_password = $request->has("password") || $request->has("password_confirmation");

        if ($modify_password) {
            $rules = array_merge($rules,[
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8'
            ]);
        }

        Validator::make($request->all(), $rules)->validate();

        if ($modify_password) {
            $user->update($request->all());
        }
        else {
            $user->update($request->except(["password", "password_confirmation"]));
        }

        return redirect()
            ->route("user.index")
            ->with("message", "Perubahan pada data pengguna berhasil dilakukan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return back()
                ->withErrors(["delete" => "Anda tidak dapat menghapus data pengguna Anda sendiri!"]);
        }

        User::find($id)->delete();
        return back()->with("message", "Penghapusan user berhasil dilakukan");
    }
}
