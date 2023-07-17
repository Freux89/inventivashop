<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_localizations', function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id');
            $table->string('lang_key'); 
            $table->string('name');
            $table->text('brand_image')->nullable(); 
            $table->string('meta_title')->nullable();
            $table->text('meta_image')->nullable();
            $table->longText('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_localizations');
    }
}
