<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAltTextAndDescriptionToMediaManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_managers', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('media_extension');
            $table->text('description')->nullable()->after('alt_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_managers', function (Blueprint $table) {
            $table->dropColumn('alt_text');
            $table->dropColumn('description');
        });
    }
}
