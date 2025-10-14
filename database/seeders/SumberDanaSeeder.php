<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SumberDanaSeeder extends Seeder
{
    /**
     * Jalankan semua seeder (langsung dipanggil dari sini).
     */
    public function run(): void
    {
        // Seeder untuk tabel sumber_danas
        DB::table('sumber_danas')->insert([
            ['nama_sumber_dana' => 'APBN'],
            ['nama_sumber_dana' => 'APBD'],
            ['nama_sumber_dana' => 'Dana Hibah'],
            ['nama_sumber_dana' => 'CSR'],
            ['nama_sumber_dana' => 'Donasi'],
        ]);
    }
}
