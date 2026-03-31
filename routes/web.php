<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard/kepala', [DashboardController::class, 'kepala']);
Route::get('/data-buku/kepala', [BukuController::class, 'kepala']);
Route::get('/laporan/peminjaman', [LaporanController::class, 'index']);

Route::resource('petugas', PetugasController::class)->parameters([
    'petugas' => 'petugas'
]);

Route::get('/data-anggota', [AnggotaController::class, 'index']);


