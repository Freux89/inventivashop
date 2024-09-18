<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuColumnItemsTableForStyles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_column_items', function (Blueprint $table) {
            // Rimuove la colonna 'style'
            $table->dropColumn('style');

            // Aggiunge le nuove colonne per gestire lo stile del titolo
            $table->unsignedTinyInteger('font_size')->default(14)->after('position'); // Grandezza del font con valore di default 14
            $table->string('title_color')->nullable()->after('font_size'); // Colore del sottotitolo
            $table->boolean('is_bold')->default(false)->after('title_color'); // Se il testo è in grassetto
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_column_items', function (Blueprint $table) {
            // Ripristina la colonna 'style'
            $table->string('style')->nullable();

            // Rimuove le nuove colonne
            $table->dropColumn('font_size');
            $table->dropColumn('title_color');
            $table->dropColumn('is_bold');
        });
    }
}
