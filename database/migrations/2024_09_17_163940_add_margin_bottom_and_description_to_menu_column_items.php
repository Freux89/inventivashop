<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarginBottomAndDescriptionToMenuColumnItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_column_items', function (Blueprint $table) {
            // Aggiungi la colonna 'margin_bottom' subito dopo 'margin_top'
            $table->integer('margin_bottom')->nullable()->after('margin_top');

            // Aggiungi la colonna 'description' subito dopo 'image_id'
            $table->text('description')->nullable()->after('image_id');
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
            $table->dropColumn('margin_bottom');
            $table->dropColumn('description');
        });
    }
}
