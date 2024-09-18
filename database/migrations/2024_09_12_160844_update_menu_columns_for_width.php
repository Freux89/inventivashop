<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuColumnsForWidth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rimuove la colonna 'image_link' dalla tabella 'menu_columns'
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->dropColumn('image_link');
        });

        // Aggiunge la colonna 'column_width' subito dopo 'position'
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->unsignedTinyInteger('column_width')->default(12)->after('position'); // da 1 a 12 per colonna Bootstrap
        });
    }

    public function down()
    {
        // Ripristina la colonna 'image_link' nella tabella 'menu_columns'
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->string('image_link')->nullable();
        });

        // Rimuove la colonna 'column_width' dalla tabella 'menu_columns'
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->dropColumn('column_width');
        });
    }
}
