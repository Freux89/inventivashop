<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionVariationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_variation_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id');
            $table->unsignedBigInteger('variation_value_id');
            $table->timestamps();

            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
            $table->foreign('variation_value_id')->references('id')->on('variation_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_variation_values');
    }
}
