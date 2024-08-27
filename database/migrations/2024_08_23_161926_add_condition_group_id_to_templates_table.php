<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionGroupIdToTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_group_id')->nullable()->after('template_type');
        
            // Aggiungere una foreign key opzionale (facoltativo)
            $table->foreign('condition_group_id')->references('id')->on('condition_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign(['condition_group_id']);
        $table->dropColumn('condition_group_id');
        });
    }
}
