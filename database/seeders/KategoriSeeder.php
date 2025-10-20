<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Perabotan UKS', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Aksesoris', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Perabotan LAB PPLG', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Obat - Obatan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
