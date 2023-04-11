<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->index()->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('serial');
            $table->bigInteger('number');
            $table->date('emited_date');
            $table->string('provider_name');
            $table->string('provider_reg_com_nr');
            $table->string('provider_cui');
            $table->string('provider_address');
            $table->string('provider_iban');
            $table->string('provider_bank');
            $table->string('provider_capital');
            $table->string('customer_name');
            $table->string('customer_reg_com_nr')->nullable();
            $table->string('customer_cui')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_county')->nullable();
            $table->string('customer_iban')->nullable();
            $table->string('customer_bank')->nullable();
            $table->double('total_fara_tva', 10, 2)->nullable();
            $table->double('total_tva', 10, 2)->nullable();
            $table->float('total_general', 10, 2)->nullable();
            $table->integer('cota');
            $table->string('termen_de_plata')->nullable();
            $table->string('payment_url')->nullable();
            $table->boolean('taxare_inversa')->default(false);
            $table->bigInteger('storno_invoice_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
