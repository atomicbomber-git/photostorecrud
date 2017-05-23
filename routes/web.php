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
    
    /*---Item related routes---*/

    /* You don't have to be have extra authorizations in order to view items */
    Route::get("item", "ItemController@index")->name("item.index");

    /* Item management routes that need an extra authorization */
    Route::group(["middleware" => "can:manage-items"], function() {
        Route::get("item/create", "ItemController@create")->name("item.create");
        Route::post("item/store", "ItemController@store")->name("item.store");
        Route::delete("item/{id}", "ItemController@destroy")->name("item.destroy");
        Route::get("item/{id}/edit", "ItemController@edit")->name("item.edit");
        Route::patch("item/{id}", "ItemController@update")->name("item.update");
        Route::get("item/{id}/restore","ItemController@restore")->name("item.restore");
    });

    Route::get("item/{id}", "ItemController@show")->name("item.show");

    /*---Category related routes---*/
    Route::group(["middleware" => "can:manage-categories"], function() {
        Route::resource("category", "CategoryController");
    });

    /*---User related routes---*/
    Route::group(["middleware" => "can:manage-users"], function() {
        Route::resource("user", "UserController");
    });

    /*---Invoice related routes---*/
    Route::get("invoice", "InvoiceController@index")->name("invoice.index");
    Route::get("invoice/create", "InvoiceController@create")->name("invoice.create");
    Route::post("invoice", "InvoiceController@store")->name("invoice.store");
    Route::patch("invoice/{invoice}", "InvoiceController@update")->name("invoice.update");


    Route::get("invoice/{invoice}", "InvoiceController@show")->name("invoice.show")
        ->middleware("can:update-invoices,invoice");

    /*---Invoice item related routes---*/
    Route::get("invoice_item", "InvoiceItemController@index")->name("invoice.item.index");
    Route::post("invoice_item", "InvoiceItemController@store")->name("invoice.item.store");
    Route::delete("invoice_item/{id}", "InvoiceItemController@destroy")->name("invoice.item.destroy");
    Route::patch("invoice_item/{invoice}", "InvoiceItemController@update")->name("invoice.item.update");
});

Route::get("error/403", "ErrorController@unauthorized")->name("error.403");
Route::get("error/404", "ErrorController@notFound")->name("error.404");