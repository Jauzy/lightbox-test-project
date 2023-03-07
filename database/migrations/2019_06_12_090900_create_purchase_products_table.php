<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('order_id')->default(0);
            $table->unsignedInteger('product_id')->default(0);
            $table->string('model');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->integer('qty')->default(1);
            $table->decimal('final', 10, 2)->default(0.00);
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
        Schema::dropIfExists('purchase_products');
    }
}
