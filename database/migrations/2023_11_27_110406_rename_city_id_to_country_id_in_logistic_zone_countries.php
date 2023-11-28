<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCityIdToCountryIdInLogisticZoneCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_zone_countries', function (Blueprint $table) {
            $table->renameColumn('city_id', 'country_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_zone_countries', function (Blueprint $table) {
            $table->renameColumn('country_id', 'city_id');
        });
    }
}
