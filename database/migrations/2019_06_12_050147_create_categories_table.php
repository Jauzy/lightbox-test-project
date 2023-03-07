<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->default(0);
            $table->string('url');
            $table->string('heading');
            $table->string('thumb')->default('none');
            $table->string('banner')->default('none');
            $table->string('title');
            $table->text('description');
            $table->text('keywords');
            $table->text('intro');
            $table->longText('content');
            $table->boolean('homepage')->default(0);
            $table->boolean('published')->default(1);
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
        Schema::dropIfExists('categories');
    }
}
