<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('product_variation_id');
            $table->integer('qty')->default(1);
            $table->integer('location_id')->nullable();
            $table->double('unit_price')->default('0.00');
            $table->double('total_tax')->default('0.00');
            $table->double('total_price')->default('0.00');
            $table->bigInteger('reward_points')->default(0);
            $table->tinyInteger('is_refunded')->default(0);
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
        Schema::dropIfExists('order_items');
    }
}
