<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameLogisticZoneCitiesToLogisticZoneCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_zone_cities', function (Blueprint $table) {
            Schema::rename('logistic_zone_cities', 'logistic_zone_countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_zone_cities', function (Blueprint $table) {
            Schema::rename('logistic_zone_countries', 'logistic_zone_cities');
        });
    }
}
