<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function peminjaman()
    {
        $peminjaman = Peminjaman::with(['anggota','buku'])->get();

        return view('kepala.laporan.peminjaman', compact('peminjaman'));
    }

        public function pengembalian()
    {
        return view ('kepala.laporan.pengembalian');
    }

    public function denda()
    {
        return view ('kepala.laporan.denda');
    }
}
