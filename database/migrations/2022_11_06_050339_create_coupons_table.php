<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); 
            $table->integer('shop_id');
            $table->text('banner')->nullable();
            $table->string('code');
            $table->string('discount_type')->comment('flat/percentage');
            $table->double('discount_value')->default(0.00);
            $table->tinyInteger('is_free_shipping')->default(0);
            $table->text('start_date')->nullable();
            $table->text('end_date')->nullable();
            $table->double('min_spend')->default(0.00);
            $table->double('max_discount_amount')->default(0.00);
            $table->integer('total_usage_limit')->default(1);
            $table->integer('total_usage_count')->default(0);
            $table->integer('customer_usage_limit')->default(1);
            $table->longText('product_ids')->nullable()->comment('Coupon will be applicable only for the products selected');
            $table->longText('category_ids')->nullable()->comment('Coupon will be applicable only for   categories selected');
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
        Schema::dropIfExists('coupons');
    }
}
