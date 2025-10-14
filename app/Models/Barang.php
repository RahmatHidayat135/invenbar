<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'sumber_dana_id', // ✅ tambahkan kolom ini
        'jumlah',
        'satuan',
        'tanggal_pengadaan',
        'gambar',
        'detail_kondisi',
    ];

    protected $casts = [
        'detail_kondisi' => 'array', // biar JSON otomatis dikonversi ke array
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }
}
