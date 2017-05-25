<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->unique();
            $table->string("description")->nullable();
            $table->integer("stock")->unsigned();
            $table->decimal("price", 19, 4)->unsigned();
            $table->integer("category_id")->unsigned()->nullable();
            $table->string("image")->nullable();
            $table->string("thumbnail")->nullable();
            $table->timestamps();

            $table->foreign("category_id")->references("id")->on("categories")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
