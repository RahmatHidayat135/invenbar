<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangUnit extends Model
{
    protected $fillable = ['barang_id', 'kondisi', 'jumlah'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
