<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarginTopToMenuColumnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_column_items', function (Blueprint $table) {
            $table->unsignedTinyInteger('margin_top')->default(0)->after('is_bold'); // Valori di Bootstrap (0, 1, 2, 3, ecc.)

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
            $table->dropColumn('margin_top');
        });
    }
}
