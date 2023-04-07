<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->index()->unsigned()->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->string('product_name');
            $table->string('unit');
            $table->integer('quantity');
            $table->double('price',10,2);
            $table->double('pret_fara_tva',10,2);
            $table->double('valoare_fara_tva',10,2);
            $table->double('valoare_tva',10,2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_lines');
    }
};
