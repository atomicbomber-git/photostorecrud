<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("quantity")->unsigned();
            $table->integer("item_id")->unsigned();
            $table->foreign("item_id")->references("id")->on("items")
                ->onDelete("cascade");

            $table->integer("invoice_id")->unsigned()->nullable();
            $table->foreign("invoice_id")->references("id")->on("invoices")
                ->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
