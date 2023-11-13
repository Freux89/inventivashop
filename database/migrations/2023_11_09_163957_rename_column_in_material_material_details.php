<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInMaterialMaterialDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_material_details', function (Blueprint $table) {
            $table->renameColumn('thickness_id', 'material_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_material_details', function (Blueprint $table) {
            $table->renameColumn('material_detail_id', 'thickness_id');
        });
    }
}
