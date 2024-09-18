<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_columns', function (Blueprint $table) {
            $table->id(); // Identificativo unico della colonna
            $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade'); // Riferimento all'ID della voce di menu
            $table->string('title')->nullable(); // Titolo della colonna
            $table->integer('position')->default(0); // Posizione della colonna nel menu
            $table->foreignId('image_id')->nullable()->constrained('media_managers')->onDelete('set null'); // Riferimento all'ID dell'immagine
            $table->boolean('image_link')->default(false); // Indicatore se l'immagine ha un link
            $table->timestamps(); // Timestamp per la creazione e aggiornamento
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_columns');
    }
}
