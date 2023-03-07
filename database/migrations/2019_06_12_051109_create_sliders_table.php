<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cover');
            $table->string('tagline')->default('n/a');
            $table->string('btntext')->default('n/a');
            $table->string('href')->default('#');
            $table->date('start_on');
            $table->date('ends_on');
            $table->integer('partner')->default(0);
            $table->integer('brand')->default(0);
            $table->longText('products')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
