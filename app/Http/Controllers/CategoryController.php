<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("category.index", [
            "categories" => Category::orderBy("created_at", "desc")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("category.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        Category::create([
            "name" => $request->get("name"),
            "description" => $request->get("description")
        ])->save();

        return redirect()
            ->route("category.index")
            ->with(["message" => "Penambahan kategori baru berhasil dilakukan!"]);
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
        return view("category.edit", [
            "category" => Category::find($id)
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
        $this->validateRequest($request);

        Category::find($id)
            ->update([
                "name" => $request->get("name"),
                "description" => $request->get("description")
            ]);

        return redirect()
            ->route("category.index")
            ->with("message", "Perubahan berhasil dilakukan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();

        return redirect()
            ->route("category.index")
            ->with("message", "Penghapusan kategori berhasil dilakukan!");
    }

    private function validateRequest($request) {
        $rules = [ 
            "name" => "required|string|min:4|unique:users"
        ];

        $errors = [
            "min" => "Minimal panjang karakter untuk kolom ini adalah :min karakter",
            "required" => "Kolom ini wajib diisi"
        ];

        Validator::make($request->all(), $rules, $errors)->validate();
    }
}
