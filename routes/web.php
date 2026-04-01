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

// --- Halaman Kepala (Semua yang berawalan /kepala/...) ---
Route::prefix('kepala')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'kepala']);
    Route::get('/data-buku', [BukuController::class, 'kepala']);
    Route::get('/laporan/peminjaman', [LaporanController::class, 'index']);

    Route::resource('petugas', PetugasController::class)->parameters([
        'petugas' => 'petugas'
    ]);

    Route::get('/data-anggota', [AnggotaController::class, 'index']);


});