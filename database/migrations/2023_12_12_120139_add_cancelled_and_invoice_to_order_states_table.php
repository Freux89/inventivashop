<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelledAndInvoiceToOrderStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_states', function (Blueprint $table) {
            $table->boolean('cancelled')->default(0)->after('color');
            $table->boolean('invoice')->default(0)->after('cancelled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_states', function (Blueprint $table) {
            $table->dropColumn(['cancelled', 'invoice']);
        });
    }
}
