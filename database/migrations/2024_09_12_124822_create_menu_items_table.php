<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id(); // Identificativo unico della voce di menu
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade'); // Riferimento all'ID del menu
            $table->string('title'); // Titolo della voce del menu
            $table->string('url')->nullable(); // URL personalizzato
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null'); // Riferimento all'ID di un prodotto
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Riferimento all'ID di una categoria
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade'); // Riferimento all'ID della voce di menu padre
            $table->boolean('is_dropdown')->default(false); // Indicatore se ha un menu a discesa
            $table->boolean('has_columns')->default(false); // Indicatore se ha un menu a colonne
            $table->integer('position')->default(0); // Posizione della voce del menu
            $table->string('style')->nullable(); // Stile CSS personalizzato
            $table->boolean('show_on_mobile')->default(true); // Visualizzazione su mobile
            $table->boolean('show_on_tablet')->default(true); // Visualizzazione su tablet
            $table->boolean('show_on_desktop')->default(true); // Visualizzazione su desktop
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
        Schema::dropIfExists('menu_items');
    }
}
