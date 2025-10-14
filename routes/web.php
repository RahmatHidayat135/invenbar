<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SumberDanaController;

// =========================
// 🏠 Halaman Awal
// =========================
Route::get('/', function () {
    return view('welcome');
});

// =========================
// 🔐 Auth & Verified Middleware
// =========================
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Barang
    Route::get('/barang/laporan', [BarangController::class, 'laporan'])->name('barang.laporan');
    Route::get('/barang/laporan/cetak', [BarangController::class, 'cetakLaporan'])->name('barang.laporan.cetak');
    Route::resource('barang', BarangController::class);

    // Kategori, Lokasi, dan User
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);

    // Hanya admin yang boleh kelola user
    Route::resource('user', UserController::class)->middleware('role:admin');

    // Peminjaman
    Route::get('/peminjaman/laporan', [PeminjamanController::class, 'cetakLaporan'])->name('peminjaman.laporan');
    Route::put('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::resource('peminjaman', PeminjamanController::class);

    // ✅ Sumber Dana
    // (Hanya perlu auth + verified, tidak perlu role admin kecuali kamu mau batasi)
    Route::resource('sumber-dana', SumberDanaController::class);
});

// =========================
// 👤 Profile User
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================
// 🧩 Unit Barang (sub-data Barang)
// =========================
Route::prefix('barang')->middleware('auth')->group(function () {
    Route::post('{barang}/unit', [BarangController::class, 'storeUnit'])->name('barang.unit.store');
    Route::put('unit/{unit}', [BarangController::class, 'updateUnit'])->name('barang.unit.update');
    Route::delete('unit/{unit}', [BarangController::class, 'destroyUnit'])->name('barang.unit.destroy');
});

require __DIR__ . '/auth.php';
