<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function peminjaman()
    {
        $peminjaman = Peminjaman::with(['anggota','buku'])->get();

        return view('kepala.laporan.peminjaman', compact('peminjaman'));
    }

       // Sesuai Route::get('/laporan/denda', ...)->name('laporan.denda')
    public function denda()
    {
        // Mengambil data denda beserta relasi anggotanya dan bukunya
        $denda = Denda::with(['anggota', 'buku'])->latest()->get();

        // Mengarahkan ke view di folder resources/views/kepala/laporan-denda.blade.php
        return view('kepala.laporan.denda', compact('denda'));
    }

    public function pengembalian() {
        return view('kepala.laporan.pengembalian');
    }
}
