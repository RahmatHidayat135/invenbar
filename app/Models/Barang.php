<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // Sesuaikan nama tabel dengan migrasi
    protected $table = 'barangs';

    // Jika primary key bukan "id", uncomment dan sesuaikan
    // protected $primaryKey = 'id_barang';

    // Kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'jumlah',
        'satuan',
        'kondisi',
        'tanggal_pengadaan',
        'gambar',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi ke lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
