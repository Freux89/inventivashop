<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_localizations', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('lang_key'); 
            $table->string('name');
            $table->text('thumbnail_image')->nullable(); 
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
        Schema::dropIfExists('category_localizations');
    }
}
