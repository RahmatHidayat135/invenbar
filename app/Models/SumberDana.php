<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    use HasFactory;

    protected $fillable = ['nama_sumber_dana'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
