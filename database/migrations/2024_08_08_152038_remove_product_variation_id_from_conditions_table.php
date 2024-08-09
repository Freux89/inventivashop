<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProductVariationIdFromConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conditions', function (Blueprint $table) {
            $table->dropForeign(['product_variation_id']);
            $table->dropColumn('product_variation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conditions', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variation_id')->after('condition_group_id');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });
    }
}
