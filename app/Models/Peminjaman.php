<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // 🔥 tambahin ini biar ke tabel yang benar
    protected $table = 'peminjamans';

    protected $fillable = [
        'barang_id',
        'nama_peminjam',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
