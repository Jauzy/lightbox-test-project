<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('category_id')->default(0);
            $table->string('model')->unique();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('metadesc')->nullable();
            $table->text('metatitle')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('special', 10, 2)->default(0.00);
            $table->date('special_from')->nullable();
            $table->date('special_to')->nullable();
            $table->string('photo')->default('none.jpg');
            $table->string('dimen')->default('none.jpg');
            $table->string('photometric')->default('none.jpg');
            $table->string('accimg1')->default('none.jpg');
            $table->string('accimg2')->default('none.jpg');
            $table->string('accimg3')->default('none.jpg');
            $table->decimal('weight', 10, 2)->default(0.00);
            $table->decimal('length', 10, 2)->default(0.00);
            $table->decimal('width', 10, 2)->default(0.00);
            $table->decimal('height', 10, 2)->default(0.00);
            $table->integer('lumtype_id')->default(0);
            $table->integer('luminare_type')->default(0);
            $table->string('coltemp')->default('none');
            $table->string('dimension')->default('none');
            $table->string('ipclass')->default('none');
            $table->string('cri')->default('none');
            $table->string('dimmable')->default('none');
            $table->string('accessories')->default('none');
            $table->string('notes')->default('none');
            $table->string('revno')->default('none');
            $table->string('importdate')->default('none');
            $table->string('lumenoutput')->default('none');
            $table->string('projectvar')->default('none');
            $table->string('lightsource')->default('none');
            $table->string('optical')->default('none');
            $table->string('colorconsist')->default('none');
            $table->string('ugr')->default('none');
            $table->string('lumenmaintain')->default('none');
            $table->string('brand')->default('none');
            $table->string('driver')->default('none');
            $table->string('supplier')->default('none');
            $table->string('importfile')->default('none');
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
        Schema::dropIfExists('products');
    }
}
