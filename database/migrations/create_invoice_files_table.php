<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoice_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->index()->unsigned()->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->string('name');
            $table->string('original_name');
            $table->bigInteger('size');
            $table->string('mime_type')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_files');
    }
};
