<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_localizations', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('name')->nullable(); 
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('lang_key');
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
        Schema::dropIfExists('product_localizations');
    }
}
