<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("invoice_items", function (Blueprint $table) {
            $table->string("name")->nullable();
            $table->decimal("price", 19, 4)->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("invoice_items", function (Blueprint $table) {
            $table->dropColumn("name");
            $table->dropColumn("price");
        });
    }
}
