<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveTimestampsInMaterialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_details', function (Blueprint $table) {
            // Elimina le colonne esistenti
            $table->dropColumn(['created_at', 'updated_at']);
        });

        Schema::table('material_details', function (Blueprint $table) {
            // Ricrea le colonne alla fine della tabella
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
        Schema::table('material_details', function (Blueprint $table) {
            //
        });
    }
}
