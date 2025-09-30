<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 150);

            // Relasi ke tabel kategori
            $table->foreignId('kategori_id')
                  ->constrained('kategoris')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Relasi ke tabel lokasi
            $table->foreignId('lokasi_id')
                  ->constrained('lokasis')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->integer('jumlah')->default(0); // total jumlah unit
            $table->string('satuan', 20);
            $table->date('tanggal_pengadaan');
            $table->string('gambar')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
