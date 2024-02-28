<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAverageDeliveryDaysToLogisticZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_zones', function (Blueprint $table) {
            $table->integer('average_delivery_days')->after('standard_delivery_time')->nullable();

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
            $table->dropColumn('average_delivery_days');
        });
    }
}
