<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLongDescriptionToCategoriesAndCategoryLocalizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Aggiungi long_description alla tabella categories
        Schema::table('categories', function (Blueprint $table) {
            $table->text('long_description')->nullable()->after('description');
        });

        // Aggiungi long_description alla tabella category_localizations
        Schema::table('category_localizations', function (Blueprint $table) {
            $table->text('long_description')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rimuovi long_description dalla tabella categories
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('long_description');
        });

        // Rimuovi long_description dalla tabella category_localizations
        Schema::table('category_localizations', function (Blueprint $table) {
            $table->dropColumn('long_description');
        });
    }
}
