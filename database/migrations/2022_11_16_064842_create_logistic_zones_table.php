<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); 
            $table->integer('logistic_id'); 
            $table->double('standard_delivery_charge')->default(0.00);
            $table->double('express_delivery_charge')->default(0.00);
            $table->string('standard_delivery_time')->nullable()->comment('1 - 3 days');
            $table->string('express_delivery_time')->nullable()->comment('1 day');
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
        Schema::dropIfExists('logistic_zones');
    }
}
