<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_managers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->longText('media_file')->nullable();
            $table->integer('media_size')->nullable();
            $table->string('media_type')->nullable()->comment('video / image / pdf / ...');
            $table->text('media_name')->nullable();
            $table->string('media_extension')->nullable();
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
        Schema::dropIfExists('media_managers');
    }
}
