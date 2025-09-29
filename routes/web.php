<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;

Route::middleware(['auth'])->group(function () {

    // Custom route harus didefinisikan lebih dulu sebelum resource
    Route::get('/peminjaman/laporan', [PeminjamanController::class, 'cetakLaporan'])
    ->name('peminjaman.laporan');


    Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    // Resource route
    Route::resource('peminjaman', PeminjamanController::class);
});

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/barang/laporan', [BarangController::class, 'cetakLaporan'])->name('barang.laporan');
    Route::resource('barang', BarangController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('user', UserController::class);

    Route::get('/user', [UserController::class, 'index'])
        ->middleware(['auth', 'role:admin'])
        ->name('user.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
