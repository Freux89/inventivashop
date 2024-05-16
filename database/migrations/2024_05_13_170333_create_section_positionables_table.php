<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionPositionablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_positionables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_position_id');
            $table->unsignedBigInteger('positionable_id'); // ID della categoria, prodotto, o CMS
            $table->timestamps();

            $table->foreign('section_position_id')->references('id')->on('section_positions')->onDelete('cascade');
            $table->index(['section_position_id', 'positionable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_positionables');
    }
}
