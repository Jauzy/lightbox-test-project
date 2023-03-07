<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoodboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moodboards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('n/a');
            $table->string('photo')->default('none.jpg');
            $table->string('cover')->default('none.jpg');
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('metadesc')->nullable();
            $table->text('metatitle')->nullable();
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
        Schema::dropIfExists('moodboards');
    }
}
