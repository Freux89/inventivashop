<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_group_id');
            $table->integer('order_item_id');
            $table->integer('product_id');
            $table->string('order_payment_status')->nullable();
            $table->longText('refund_reason')->nullable();
            $table->longText('refund_reject_reason')->nullable();
            $table->string('refund_status')->default('pending')->comment('refunded/rejected');
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
        Schema::dropIfExists('refunds');
    }
}
