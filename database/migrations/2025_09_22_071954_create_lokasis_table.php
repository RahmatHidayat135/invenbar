<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokasisTable extends Migration
{
    public function up()
    {
        Schema::create('lokasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokasis');
    }
}
