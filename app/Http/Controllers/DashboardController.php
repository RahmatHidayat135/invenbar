<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
{
    $totalBarang = Barang::count();
    $totalKategori = Kategori::count();
    $totalLokasi = Lokasi::count();
    $totalUser = User::count();

    $baikCount = Barang::where('kondisi', 'Baik')->count();
    $rusakRinganCount = Barang::where('kondisi', 'Rusak Ringan')->count();
    $rusakBeratCount = Barang::where('kondisi', 'Rusak Berat')->count();
    $totalKondisi = $baikCount + $rusakRinganCount + $rusakBeratCount;

    $baikPercent = $totalKondisi ? ($baikCount / $totalKondisi) * 100 : 0;
    $rusakRinganPercent = $totalKondisi ? ($rusakRinganCount / $totalKondisi) * 100 : 0;
    $rusakBeratPercent = $totalKondisi ? ($rusakBeratCount / $totalKondisi) * 100 : 0;

    $barangTerbaru = Barang::with('lokasi')->latest()->take(5)->get();

    return view('dashboard', compact(
        'totalBarang', 'totalKategori', 'totalLokasi', 'totalUser',
        'baikCount', 'rusakRinganCount', 'rusakBeratCount',
        'baikPercent', 'rusakRinganPercent', 'rusakBeratPercent',
        'barangTerbaru'
    ));
}

}
