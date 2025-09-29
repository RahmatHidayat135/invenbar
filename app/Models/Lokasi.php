<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lokasi',
    ];

    // Relasi: satu lokasi punya banyak barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }
}
