<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('moodboard_id')->default(0);
            $table->string('title');
            $table->string('photo')->default('none.jpg');
            $table->text('designs')->nullable();
            $table->integer('min_budget')->default(0);
            $table->integer('max_budget')->default(0);
            $table->integer('min_area')->default(0);
            $table->integer('max_area')->default(0);
            $table->text('description');
            $table->text('keywords')->nullable();
            $table->text('metadesc')->nullable();
            $table->text('metatitle')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->text('related');
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
        Schema::dropIfExists('pins');
    }
}
