<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultPriceToVariationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variation_values', function (Blueprint $table) {
            $table->decimal('default_price', 8, 2)->nullable()->after('name'); // Aggiungi la colonna default_price

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variation_values', function (Blueprint $table) {
            $table->dropColumn('default_price'); // Rimuovi la colonna default_price

        });
    }
}
