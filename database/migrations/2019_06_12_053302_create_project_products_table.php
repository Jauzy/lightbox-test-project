<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('project')->default(0);
            $table->string('code')->default('n/a');
            $table->string('supplier')->default('n/a');
            $table->string('lumtype')->default('n/a');
            $table->string('coltemp')->default('n/a');
            $table->string('iprating')->default('n/a');
            $table->string('cri')->default('n/a');
            $table->string('acc')->default('n/a');
            $table->string('notes')->default('n/a');
            $table->date('dt');
            $table->string('wattage')->default('n/a');
            $table->string('finish')->default('n/a');
            $table->string('driver')->default('n/a');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('qty')->default(1);
            $table->string('level')->default('design');
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
        Schema::dropIfExists('project_products');
    }
}
