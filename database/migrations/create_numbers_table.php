<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('numbers', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->bigInteger('number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('numbers');
    }
};
