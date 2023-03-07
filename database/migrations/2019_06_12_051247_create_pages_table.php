<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent')->default(0);
            $table->string('title');
            $table->string('banner')->default('none.jpg');
            $table->string('menu');
            $table->string('menupos')->default('top');
            $table->string('url');
            $table->text('keywords')->nullable();
            $table->text('metadesc')->nullable();
            $table->text('metatitle')->nullable();
            $table->longText('content')->nullable();
            $table->tinyInteger('publish')->default(1);
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
        Schema::dropIfExists('pages');
    }
}
