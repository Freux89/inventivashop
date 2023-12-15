<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsToUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->after('user_id', function ($table) {
                $table->string('address_name');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone');
            });
            $table->string('postal_code')->after('address');
            $table->after('postal_code', function ($table) {
                $table->unsignedTinyInteger('document_type');
            // Campi per la fattura elettronica
            $table->string('company_name')->nullable();
            $table->string('vat_id')->nullable();
            $table->string('fiscal_code')->nullable();
            $table->string('pec')->nullable();
            $table->string('exchange_code')->nullable();
            });
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn(['address_name', 'first_name', 'last_name', 'phone', 'postal_code', 'document_type', 'company_name', 'vat_id', 'fiscal_code', 'pec', 'exchange_code']);

        });
    }
}
