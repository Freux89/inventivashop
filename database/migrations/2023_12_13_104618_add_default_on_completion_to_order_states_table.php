<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultOnCompletionToOrderStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_states', function (Blueprint $table) {
            $table->boolean('default_on_completion')->after('visible_to_customer')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_states', function (Blueprint $table) {
            $table->dropColumn('default_on_completion');

        });
    }
}
