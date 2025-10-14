<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        Peminjaman::insert([
            [
                'nama_peminjam' => 'Rahmat Hidayat',
                'barang_id' => 1,
                'tanggal_pinjam' => now()->subDays(5),
                'tanggal_kembali' => now()->addDays(2),
                'status' => 'Dipinjam'
            ],
            [
                'nama_peminjam' => 'Siti Aminah',
                'barang_id' => 2,
                'tanggal_pinjam' => now()->subDays(10),
                'tanggal_kembali' => now()->subDays(3),
                'status' => 'Dikembalikan'
            ],
        ]);
    }
}
