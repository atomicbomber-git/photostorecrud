<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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

        $filename = $this->storeImage($request->image);

        Item::create(array_merge($request->all(), ["image" => $filename]));
        return redirect()
            ->route("item.index")
            ->with("message", "Penambahan barang baru berhasil dilakukan.");
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
        return view("item.edit", [
            "item" => Item::find($id),
            "categories" => Category::get()
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
        $validation_rules = [
            "name" => "required|string|unique:items,name,$id",
            "category_id" => "required|integer",
            "description" => "required|string",
            "stock" => "required|integer|min:0",
            "price" => "required|integer|min:0"
        ];

        if ($request->hasFile("image")) {
            $validation_rules["image"] = "file|image";
        }

        Validator::make($request->all(), $validation_rules)->validate();

        $item = Item::find($id);

        if ($request->hasFile("image")) {
            $filename = $this->storeImage($request->image);

            unlink(storage_path("app/public/thumbnails/$item->image"));
            unlink(storage_path("app/public/images/$item->image"));

            $item->update(["image" => $filename]);
        }

        return redirect()->route("item.index");
    }

    private function storeImage($imageFile)
    {
        if (!$imageFile->isValid()) {
            throw new \Exception("Uploaded file is not valid!");
        }

        /* Store the image and obtain its file path */
        $savePath = $imageFile->store("public/images");

        /* Create a thumbnail based on the original image */
        $thumbnail = Image::make($imageFile);

        /* Resize the thumbnail proportionally. */
        $target_size = 200;

        $thumbnail->resize(null, 200, function ($constraint){
            $constraint->aspectRatio();
        });

        /* Save the thumbnail with the same filename as the original file */
        $filename = $imageFile->hashName();
        $thumbnail->save(storage_path("app/public/thumbnails/$filename"));

        return $filename;
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
                    "delete_success" => "Anda baru saja menonaktifkan sebuah item bernama \"$item->name\" dengan id $item->id.",
                    "deleted_item_id" => $id
                ]);
    }

    public function restore($id)
    {
        Item::withTrashed()->find($id)->restore();
        return redirect()->back();
    }
}
