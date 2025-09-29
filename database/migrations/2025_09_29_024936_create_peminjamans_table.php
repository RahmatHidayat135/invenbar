<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade'); // ✅ Relasi ke barang
            $table->string('nama_peminjam');
            $table->integer('jumlah');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->string('status')->default('Dipinjam');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
