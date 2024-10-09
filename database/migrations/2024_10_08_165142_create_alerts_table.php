<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Il titolo non visibile
            $table->text('text'); // Testo visibile
            $table->string('background_color')->nullable(); // Colore di sfondo
            $table->dateTime('start_date')->nullable(); // Data di inizio
            $table->dateTime('end_date')->nullable(); // Data di fine
            $table->boolean('is_active')->default(true); // Se l'avviso è attivo
            $table->enum('display_location', ['all_pages', 'homepage', 'all_categories', 'specific_categories', 'all_products', 'specific_products'])->default('all_pages');
            $table->json('category_ids')->nullable(); // ID delle categorie specifiche (se applicabile)
            $table->json('product_ids')->nullable(); // ID dei prodotti specifici (se applicabile)
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
        Schema::dropIfExists('alerts');
    }
}
