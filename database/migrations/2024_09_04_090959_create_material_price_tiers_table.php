<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialPriceTiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_price_tiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->decimal('min_quantity', 10, 4); // Quantità minima per cui si applica il prezzo
            $table->decimal('price', 10, 4); // Prezzo associato alla quantità minima
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_price_tiers');
    }
}
