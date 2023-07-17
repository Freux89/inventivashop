<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('guest_user_id')->nullable();
            $table->bigInteger('order_code');
            $table->integer('shipping_address_id')->nullable();
            $table->integer('billing_address_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('alternative_phone_no')->nullable();
            $table->double('sub_total_amount')->default('0.00');
            $table->double('total_tax_amount')->default('0.00');
            $table->double('total_coupon_discount_amount')->default('0.00');
            $table->double('total_shipping_cost')->default('0.00');
            $table->double('grand_total_amount')->default('0.00');
            $table->string('payment_method')->default('cash_on_delivery');
            $table->string('payment_status')->default('unpaid');
            $table->longText('payment_details')->nullable();
            $table->boolean('is_manual_payment')->default(0);
            $table->longText('manual_payment_details')->nullable();
            $table->tinyInteger('is_pos_order')->default(0);
            $table->text('pos_order_address')->nullable();
            $table->double('additional_discount_value')->default('0.00');
            $table->string('additional_discount_type')->default('flat');
            $table->double('total_discount_amount')->default('0.00');
            $table->double('total_tips_amount')->default('0.00');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_groups');
    }
}
