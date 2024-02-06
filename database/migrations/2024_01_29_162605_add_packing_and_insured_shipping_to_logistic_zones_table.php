<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPackingAndInsuredShippingToLogisticZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_zones', function (Blueprint $table) {
            $table->double('packing_cost', 8, 2)->after('standard_delivery_charge')->nullable();
            $table->double('insured_shipping_cost', 8, 2)->after('packing_cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_zones', function (Blueprint $table) {
            $table->dropColumn('packing_cost');
            $table->dropColumn('insured_shipping_cost');
        });
    }
}
