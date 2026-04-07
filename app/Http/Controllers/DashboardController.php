<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function kepala()
    {
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalBuku = Buku::count();

        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        $totalDenda = Peminjaman::sum('denda');

        $aktivitas = Peminjaman::latest()->take(5)->get();

        return view('kepala.dashboard', compact(
            'totalAnggota',
            'totalPetugas',
            'totalBuku',
            'bukuDipinjam',
            'totalDenda',
            'aktivitas'
        ));
    }

    public function petugas()
    {
        return view('petugas.dashboard');
    }
}
