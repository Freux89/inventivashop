<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialDetailLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_detail_localizations', function (Blueprint $table) {
            $table->id();
        $table->foreignId('material_detail_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('lang_key');
        // Altre colonne per la localizzazione se necessario
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
        Schema::dropIfExists('material_detail_localizations');
    }
}
