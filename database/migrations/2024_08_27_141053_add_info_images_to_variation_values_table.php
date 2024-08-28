<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoImagesToVariationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variation_values', function (Blueprint $table) {
            $table->unsignedBigInteger('info_image_id')->nullable()->after('info_description')->comment('ID of the image for the info box');
            $table->string('info_slider_image_ids')->nullable()->after('info_image_id')->comment('Comma-separated IDs of images for the slider in the info box');
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
            $table->dropColumn('info_image_id');
            $table->dropColumn('info_slider_image_ids');
        });
    }
}
