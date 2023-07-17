<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('is_approved')->default(0);
            $table->tinyInteger('is_verified_by_admin')->default(0);
            $table->tinyInteger('is_published')->default(0);
            $table->text('shop_logo')->nullable(); 
            $table->string('shop_name');
            $table->text('slug');
            $table->double('shop_rating')->default(0.00);
            $table->longText('shop_address')->nullable();
            $table->double('min_order_amount')->default(0.00); 
            $table->double('admin_commission_percentage')->default(0.00);
            $table->double('current_balance')->default(0.00);
            $table->tinyInteger('is_cash_payout')->default(0);
            $table->tinyInteger('is_bank_payout')->default(0);
            $table->string('bank_name')->nullable();
            $table->string('bank_acc_name')->nullable();
            $table->string('bank_acc_no')->nullable();
            $table->integer('bank_routing_no')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
