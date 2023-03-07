<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pin_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('moodboard_id');
            $table->unsignedInteger('pin_id')->default(0);
            $table->unsignedInteger('product_id')->default(0);
            $table->tinyInteger('x')->default(0);
            $table->tinyInteger('y')->default(0);
            $table->tinyInteger('z')->default(0);
            $table->tinyInteger('areaid')->default(0);
            $table->tinyInteger('height')->default(0);
            $table->tinyInteger('width')->default(0);
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
        Schema::dropIfExists('pin_products');
    }
}
