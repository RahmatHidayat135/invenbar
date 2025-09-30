<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'kode_barang' => 'LP001',
                'nama_barang' => 'Laptop Dell Latitude 5420',
                'kategori_id' => 1,
                'lokasi_id' => 4,
                'jumlah' => 1,
                'satuan' => 'Unit',
                'detail_kondisi' => json_encode(['Baik' => 1]),
                'tanggal_pengadaan' => '2023-05-15',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_barang' => 'PRJ001',
                'nama_barang' => 'Proyektor Epson EB-X500',
                'kategori_id' => 1,
                'lokasi_id' => 1,
                'jumlah' => 1,
                'satuan' => 'Unit',
                'detail_kondisi' => json_encode(['Baik' => 1]),
                'tanggal_pengadaan' => '2022-11-20',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_barang' => 'MJ005',
                'nama_barang' => 'Meja Rapat Kayu Jati',
                'kategori_id' => 2,
                'lokasi_id' => 1,
                'jumlah' => 1,
                'satuan' => 'Buah',
                'detail_kondisi' => json_encode(['Baik' => 1]),
                'tanggal_pengadaan' => '2021-02-10',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_barang' => 'ATK-SP-01',
                'nama_barang' => 'Spidol Whiteboard Snowman',
                'kategori_id' => 3,
                'lokasi_id' => 3,
                'jumlah' => 50,
                'satuan' => 'Pcs',
                'detail_kondisi' => json_encode(['Baik' => 50]),
                'tanggal_pengadaan' => '2024-01-30',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
