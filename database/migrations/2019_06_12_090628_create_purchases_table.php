<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->default(0);
            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->text('purchase_notes')->nullable();
            $table->string('purchase_status')->default('pending');
            $table->date('purchased_on');
            //payment
            $table->string('payment_method')->default('PayPal');
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('shipping', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('grand_total', 10, 2)->default(0.00);
            //shipping
            $table->string('shipping_method')->default('Fedex');
            $table->string('shipping_first_name');
            $table->string('shipping_last_name');
            $table->string('shipping_email');
            $table->string('shipping_phone');
            $table->string('shipping_address_line_1');
            $table->string('shipping_address_line_2');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_country');
            $table->string('shipping_postcode');
            //billing
            $table->string('billing_method')->default('Fedex');
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->string('billing_address_line_1');
            $table->string('billing_address_line_2');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_country');
            $table->string('billing_postcode');
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
        Schema::dropIfExists('purchases');
    }
}
