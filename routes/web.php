<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::get('/', function () {
    return view('landing');
});

// AUTH ROUTES
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Halaman Kepala ---
Route::prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'kepala'])->name('dashboard');
    Route::get('/data-buku', [BukuController::class, 'kepala'])->name('data-buku');
    Route::get('/data-anggota', [AnggotaController::class, 'kepala'])->name('data-anggota');
    
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/denda', [LaporanController::class, 'denda'])->name('laporan.denda');

    Route::resource('petugas', PetugasController::class)
    ->parameters(['petugas' => 'petugas']);
});

// --- Halaman Petugas ---
Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard');
    
    Route::resource('buku', BukuController::class);
    Route::get('/data-anggota', [AnggotaController::class, 'index'])->name('data-anggota');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/pengembalian', [LaporanController::class, 'pengembalian'])->name('pengembalian');
    Route::get('/denda', [LaporanController::class, 'denda'])->name('denda');
});
