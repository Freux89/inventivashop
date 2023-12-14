<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderStateIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_state_id')->nullable()->after('location_id');
            $table->foreign('order_state_id')->references('id')->on('order_states')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['order_state_id']);
            $table->dropColumn('order_state_id');
        });
    }
}
