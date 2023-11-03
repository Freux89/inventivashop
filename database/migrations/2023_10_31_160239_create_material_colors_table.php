<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_colors', function (Blueprint $table) {
            $table->id();
            $table->string('color_name');
            $table->string('hex_value'); // codice colore HEX, ad esempio: #FF5733
            $table->string('thumbnail_image')->nullable(); // percorso all'immagine thumbnail
            $table->string('pattern_image')->nullable();   // percorso all'immagine del pattern/dettaglio
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
        Schema::dropIfExists('material_colors');
    }
}
