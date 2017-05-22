<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get("/", function() {
    return redirect()->route("dashboard");
});

Route::get("/test", "MainController@test");
Route::post("/upload", "MainController@upload")->name("upload");

Route::group(["middleware" => "auth"], function() {
    Route::get("/dashboard", "MainController@dashboard")->name("dashboard");
    
    Route::group(["middleware" => "can:manage-items"], function() {
        Route::get("item/create", "ItemController@create")->name("item.create");
        Route::post("item/store", "ItemController@store")->name("item.store");
        Route::delete("item/{id}", "ItemController@destroy")->name("item.destroy");
        Route::get("item/{id}/edit", "ItemController@edit")->name("item.edit");
    });

    Route::get("item", "ItemController@index")->name("item.index");
    Route::get("item/{id}", "ItemController@show")->name("item.show");

    // Route::resource("item", "ItemController");
    Route::get("item/{id}/restore","ItemController@restore")->name("item.restore");

    Route::group(["middleware" => "can:manage-categories"], function() {
        Route::resource("category", "CategoryController");
    });

    Route::group(["middleware" => "can:manage-users"], function() {
        Route::resource("user", "UserController");
    });
});