<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent')->default(0);
            $table->string('name');
            $table->string('location');
            $table->integer('user_id')->default(0);
            $table->tinyInteger('publish')->default(1);
            $table->tinyInteger('deleted')->default(1);
            $table->integer('logo')->default(0);
            $table->tinyInteger('level')->default(0);
            $table->string('level_name')->default('n/a');
            $table->tinyInteger('allow_tender')->default(0);
            $table->date('tender_start');
            $table->date('tender_end');
            $table->longText('design');
            $table->longText('development');
            $table->longText('tender');
            $table->longText('contract');
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
        Schema::dropIfExists('projects');
    }
}
