<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplyLinkToImageToMenuColumnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_column_items', function (Blueprint $table) {
            $table->boolean('apply_link_to_image')->default(false)->after('image_id');

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
            $table->dropColumn('apply_link_to_image');
        });
    }
}
