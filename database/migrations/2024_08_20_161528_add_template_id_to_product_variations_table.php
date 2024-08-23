<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateIdToProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable()->after('product_id');
            $table->unsignedBigInteger('product_id')->nullable()->change();

            // Se esiste una foreign key per `product_id`, puoi considerare di aggiungerne una anche per `template_id`
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');

            // Rendi `product_id` non nullable di nuovo, se necessario
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
        });
    }
}
