<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_states', function (Blueprint $table) {
            $table->id();
    $table->boolean('type'); // booleano
    $table->string('name');
    $table->boolean('send_email'); // invio email (booleano)
    $table->text('email_content'); // contenuto email (long text)
    $table->boolean('status'); // status (booleano)
    $table->timestamps(); // create e update
    $table->softDeletes(); // delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_states');
    }
}
