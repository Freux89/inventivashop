<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaddingAndBorderToMenuColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->boolean('border_left')->default(false)->after('column_width');
            $table->boolean('border_right')->default(false)->after('border_left');
            $table->integer('padding_left')->default(0)->after('border_right'); // Valori da 0 a 9
            $table->integer('padding_right')->default(0)->after('padding_left'); // Valori da 0 a 9
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_columns', function (Blueprint $table) {
            $table->dropColumn(['border_left', 'border_right', 'padding_left', 'padding_right']);

        });
    }
}
