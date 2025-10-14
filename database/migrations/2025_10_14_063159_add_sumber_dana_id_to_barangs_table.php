<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Pastikan kolomnya unsignedBigInteger dan nullable
            $table->unsignedBigInteger('sumber_dana_id')->nullable()->after('lokasi_id');

            // Tambahkan foreign key yang benar
            $table->foreign('sumber_dana_id')
                  ->references('id')
                  ->on('sumber_danas')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['sumber_dana_id']);
            $table->dropColumn('sumber_dana_id');
        });
    }
};
