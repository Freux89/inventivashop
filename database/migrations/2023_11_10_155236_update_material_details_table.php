<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMaterialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_details', function (Blueprint $table) {
            // Rinomina la colonna 'value' a 'name'
            $table->renameColumn('value', 'name');

            // Aggiungi le nuove colonne
            $table->text('description')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_details', function (Blueprint $table) {
            // Se vuoi eseguire una migrazione "down", puoi invertire le operazioni qui
            $table->renameColumn('name', 'value');
            $table->dropColumn(['description', 'thumbnail_image', 'position', 'is_active']);
        });
    }
}
