<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id');
            $table->string('added_by')->default('admin');
            $table->string('name');
            $table->string('slug');
            $table->integer('brand_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->text('thumbnail_image')->nullable();
            $table->longText('gallery_images')->nullable();
            $table->longText('product_tags')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->double('min_price')->default(0.00);
            $table->double('max_price')->default(0.00);
            $table->double('discount_value')->default(0.00);
            $table->string('discount_type')->nullable();
            $table->integer('discount_start_date')->nullable();
            $table->integer('discount_end_date')->nullable();
            $table->integer('sell_target')->nullable();
            $table->integer('stock_qty')->default(0);
            $table->tinyInteger('is_published')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->integer('min_purchase_qty')->default(1);
            $table->integer('max_purchase_qty')->default(1);
            $table->tinyInteger('has_variation')->default(1);
            $table->tinyInteger('has_warranty')->default(1);
            $table->double('total_sale_count')->default(0.00);
            $table->integer('standard_delivery_hours')->default(24);
            $table->integer('express_delivery_hours')->default(24);
            $table->text('size_guide')->nullable();
            $table->mediumText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_img')->nullable();
            $table->bigInteger('reward_points')->default(0);
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
        Schema::dropIfExists('products');
    }
}
