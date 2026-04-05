<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
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
// name('kepala.') artinya semua rute di dalam akan otomatis punya awalan 'kepala.'
Route::prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'kepala'])->name('dashboard');
    Route::get('/data-buku', [BukuController::class, 'kepala'])->name('data-buku');
    Route::get('/data-anggota', [AnggotaController::class, 'kepala'])->name('data-anggota');
    
    // Pastikan nama ini sesuai dengan yang dipanggil di sidebar
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/denda', [LaporanController::class, 'denda'])->name('laporan.denda');

    Route::resource('petugas', PetugasController::class)
    ->parameters(['petugas' => 'petugas']);
});

// --- Halaman Petugas ---
// name('petugas.') artinya semua rute di dalam akan otomatis punya awalan 'petugas.'
Route::prefix('petugas')->name('petugas.')->group(function () {
     Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard');
});