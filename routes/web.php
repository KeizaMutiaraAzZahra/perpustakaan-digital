<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role == 'kepala') {
                return redirect()->route('kepala.dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect()->route('petugas.dashboard');
            } elseif ($user->role == 'anggota') {
                return redirect()->route('anggota.dashboard');
            }
        }

        return view('landing');
    });

// --- AUTH ROUTES ---
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'prosesLogin']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- HALAMAN KEPALA (Hanya role: kepala) ---
Route::prefix('kepala')->name('kepala.')->middleware(['auth', 'can:role,"kepala"'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'kepala'])->name('dashboard');
    Route::get('/data-buku', [BukuController::class, 'kepala'])->name('data-buku');
    Route::get('/data-anggota', [AnggotaController::class, 'kepala'])->name('data-anggota');
    
    // Laporan
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/denda', [LaporanController::class, 'denda'])->name('laporan.denda');

    Route::resource('petugas', PetugasController::class);
    Route::patch('/petugas/{id}/status', [PetugasController::class, 'toggleStatus'])
    ->name('petugas.toggleStatus');
});

// --- HALAMAN PETUGAS (Hanya role: petugas) ---
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'can:role,"petugas"'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard');
    
    Route::resource('buku', BukuController::class);
    Route::get('/data-anggota', [AnggotaController::class, 'index'])->name('data-anggota');
    Route::resource('peminjaman', PeminjamanController::class);
    
    // Opsional: Tambahkan route pengembalian & denda jika diperlukan petugas
    Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('pengembalian');
    Route::get('/denda', [PeminjamanController::class, 'denda'])->name('denda');
});

// --- HALAMAN ANGGOTA (Hanya role: anggota) ---
Route::prefix('anggota')->name('anggota.')->middleware(['auth', 'can:role,"anggota"'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'anggota'])->name('dashboard');
    Route::get('/katalog', [BukuController::class, 'index'])->name('katalog');
});