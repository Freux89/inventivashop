<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuColumnsAndMenuColumnItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropColumn('image_id');
        });

        // Aggiunge la colonna image_id alla tabella menu_column_items dopo category_id
        Schema::table('menu_column_items', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable()->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Ripristina la colonna image_id nella tabella menu_columns
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
        });

        // Rimuove la colonna image_id dalla tabella menu_column_items
        Schema::table('menu_column_items', function (Blueprint $table) {
            $table->dropColumn('image_id');
        });
    }
}
