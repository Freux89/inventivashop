<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityAndIncreaseDaysToWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workflows', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('duration'); // Specifica ogni quanto quantità aumentare
            $table->integer('increase_duration')->default(0)->after('quantity'); // Aumento dei giorni di lavorazione per quantità
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workflows', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('increase_duration');
        });
    }
}
