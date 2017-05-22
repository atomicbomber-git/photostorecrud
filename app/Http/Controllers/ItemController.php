<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Item;
use App\Category;

use Image;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("item.index", [
            "items" => Item::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("item.create", [
            "categories" => Category::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            "name" => "required|string|unique:items",
            "category_id" => "required|integer",
            "description" => "required|string",
            "stock" => "required|integer|min:0",
            "price" => "required|integer|min:0",
            "image" => "required|file|image"
        ])->validate();

        $image_path = $request->image->store("public/images");

        $thumbnail = Image::make($request->image);

        $resize_height = null;
        $resize_width = null;
        if ($thumbnail->width() > $thumbnail->height()) {
            $resize_width = 200;
        }
        else {
            $resize_height = 200;
        }

        $thumbnail->resize($resize_width, $resize_height, function ($constraint){
            $constraint->aspectRatio();
        });

        $filename = $request->image->hashName();
        $thumbnail->save(storage_path("app/public/thumbnails/$filename"));

        Item::create(array_merge($request->all(), ["image" => $filename]));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect()
            ->back()
            ->with([
                    "message" => "Anda baru saja menonaktifkan sebuah item bernama \"$item->name\" dengan id $item->id.",
                    "deleted_item_id" => $id
                ]);
    }

    public function restore($id)
    {
        Item::withTrashed()->find($id)->restore();
        return redirect()->back();
    }
}
