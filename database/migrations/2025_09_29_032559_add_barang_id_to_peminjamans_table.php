<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
            {
                Schema::table('peminjamans', function (Blueprint $table) {
                    if (!Schema::hasColumn('peminjamans', 'barang_id')) {
                        $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
                    }
                });
            }


        public function down(): void
            {
                Schema::table('peminjamans', function (Blueprint $table) {
                    $table->dropForeign(['barang_id']);
                    $table->dropColumn('barang_id');
                });
            }

};
