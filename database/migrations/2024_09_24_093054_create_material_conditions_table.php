<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->foreignId('variation_value_id')->constrained()->onDelete('cascade');
            $table->integer('condition_group'); // Gruppo di condizioni per la logica AND/OR
            $table->string('condition_operator', 3); // AND o OR
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
        Schema::dropIfExists('material_conditions');
    }
}
