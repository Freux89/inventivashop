<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariationColumnsToProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_id')->nullable()->after('variation_key');
            $table->unsignedBigInteger('variation_value_id')->nullable()->after('variation_id');

            // Aggiungiamo le chiavi esterne se necessario
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
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
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropForeign(['variation_id']);
            $table->dropForeign(['variation_value_id']);
            $table->dropColumn('variation_id');
            $table->dropColumn('variation_value_id');
        });
    }
}
