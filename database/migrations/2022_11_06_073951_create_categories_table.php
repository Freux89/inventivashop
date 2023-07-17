<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('level')->comment('level of the category');
            $table->integer('sorting_order_level')->default(0);
            $table->text('thumbnail_image')->nullable();
            $table->text('icon')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_top')->default(0);
            $table->integer('total_sale_count')->default(0);
            $table->mediumText('meta_title')->nullable();
            $table->text('meta_image')->nullable();
            $table->longText('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
