<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuColumnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_column_items', function (Blueprint $table) {
            $table->id(); // Identificativo unico dell'elemento della colonna
            $table->foreignId('menu_column_id')->constrained('menu_columns')->onDelete('cascade'); // Riferimento all'ID della colonna
            $table->string('title')->nullable(); // Titolo dell'elemento
            $table->string('url')->nullable(); // URL personalizzato
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null'); // Riferimento all'ID di un prodotto
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Riferimento all'ID di una categoria
            $table->integer('position')->default(0); // Posizione dell'elemento nella colonna
            $table->string('style')->nullable(); // Stile CSS personalizzato
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
        Schema::dropIfExists('menu_column_items');
    }
}
