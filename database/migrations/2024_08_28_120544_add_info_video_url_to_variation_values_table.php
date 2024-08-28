<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoVideoUrlToVariationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variation_values', function (Blueprint $table) {
            $table->string('info_video_url')->nullable()->after('info_image_id')->comment('URL of the video for the info box');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variation_values', function (Blueprint $table) {
            $table->dropColumn('info_video_url');
        });
    }
}
