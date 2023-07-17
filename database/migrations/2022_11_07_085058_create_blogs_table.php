<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug');
            $table->integer('blog_category_id');
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('thumbnail_image')->nullable(); 
            $table->longText('banner')->nullable();
            $table->string('video_provider')->default('youtube')->comment('youtube / vimeo / ...');
            $table->text('video_link')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_popular')->default(0);
            $table->mediumText('meta_title')->nullable();
            $table->text('meta_img')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
