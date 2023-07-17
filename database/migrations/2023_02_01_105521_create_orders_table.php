<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_group_id');
            $table->integer('shop_id');
            $table->integer('user_id')->nullable();
            $table->integer('guest_user_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('delivery_status')->default('order_placed');
            $table->string('payment_status')->default('unpaid');
            $table->string('applied_coupon_code')->nullable();
            $table->double('coupon_discount_amount')->default('0.00');
            $table->double('admin_earning_percentage')->default('0.00')->comment('how much in percentage seller will pay to admin for each sell');
            $table->double('total_admin_earnings')->default('0.00');
            $table->double('total_vendor_earnings')->default('0.00');
            $table->integer('logistic_id')->nullable();
            $table->string('logistic_name')->nullable();
            $table->string('pickup_or_delivery')->default('delivery');
            $table->string('shipping_delivery_type')->default('regular')->comment('regular/scheduled');
            $table->longText('scheduled_delivery_info')->nullable()->comment('keep date & time');
            $table->integer('pickup_hub_id')->nullable();
            $table->double('shipping_cost')->default('0.00');
            $table->double('tips_amount')->default('0.00');
            $table->bigInteger('reward_points')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
