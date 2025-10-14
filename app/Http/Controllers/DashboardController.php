<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\SumberDana;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalLokasi = Lokasi::count();
        $totalUser = User::count();
        $totalSumberDana = SumberDana::count();
        $totalPeminjaman = Peminjaman::count();

        // Ambil semua data detail_kondisi
        $barangs = Barang::select('detail_kondisi')->get();

        // Inisialisasi hitungan kondisi
        $baikCount = 0;
        $rusakRinganCount = 0;
        $rusakBeratCount = 0;

        // Hitung jumlah kondisi
        foreach ($barangs as $barang) {
            $kondisi = $barang->detail_kondisi;

            if (!is_array($kondisi)) {
                $kondisi = json_decode($kondisi, true) ?? [];
            }

            foreach ($kondisi as $key => $jumlah) {
                $key = strtolower(trim(str_replace('_', ' ', $key)));

                if ($key === 'baik') {
                    $baikCount += (int) $jumlah;
                } elseif ($key === 'rusak ringan') {
                    $rusakRinganCount += (int) $jumlah;
                } elseif ($key === 'rusak berat') {
                    $rusakBeratCount += (int) $jumlah;
                }
            }
        }

        // Hitung total kondisi untuk persen
        $totalKondisi = $baikCount + $rusakRinganCount + $rusakBeratCount;

        $baikPercent = $totalKondisi ? ($baikCount / $totalKondisi) * 100 : 0;
        $rusakRinganPercent = $totalKondisi ? ($rusakRinganCount / $totalKondisi) * 100 : 0;
        $rusakBeratPercent = $totalKondisi ? ($rusakBeratCount / $totalKondisi) * 100 : 0;

        // Ambil 5 barang terbaru
        $barangTerbaru = Barang::with('lokasi')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalLokasi',
            'totalUser',
            'totalSumberDana',
            'totalPeminjaman',
            'baikCount',
            'rusakRinganCount',
            'rusakBeratCount',
            'baikPercent',
            'rusakRinganPercent',
            'rusakBeratPercent',
            'barangTerbaru'
        ));
    }
}
