<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Petugas;

class DashboardController extends Controller
{
    public function kepala()
    {
        $totalAnggota = Anggota::count();
        $totalPetugas = Petugas::count();

        $totalBuku = Buku::count();

        $bukuDipinjam = Peminjaman::where('status', 'Dipinjam')->count();

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
        // 1. Ambil data total untuk kotak biru (Statistik)
        $totalAnggota = Anggota::count();
        $totalBuku = Buku::count();
        
        // Asumsi: tabel peminjaman punya kolom 'status' (dipinjam/kembali)
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        
        // Asumsi: tabel peminjaman punya kolom 'denda'
        $totalDenda = Peminjaman::sum('denda');

        // 2. Ambil Aktivitas Terbaru (3 data terakhir)
        // Kita gunakan Eager Loading 'with' supaya bisa panggil nama anggota
        $aktivitasTerbaru = Peminjaman::with('anggota')
                            ->latest()
                            ->take(3)
                            ->get();

        return view('petugas.dashboard', compact(
            'totalAnggota', 
            'totalBuku', 
            'bukuDipinjam', 
            'totalDenda', 
            'aktivitasTerbaru'
        ));
    }
}
