<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

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

        $totalAnggota = Anggota::count();
        $totalBuku = Buku::count();
        
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        

        $totalDenda = Peminjaman::sum('denda');


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

    public function anggota() 
    {
        $user = Auth::user();

        $anggota = Anggota::where('user_id', $user->id)->first();

        if (!$anggota) {
            $peminjamanAktif = 0;
            $totalDenda = 0;
            $sudahKembali = 0;
        } else {

            $peminjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                                ->where('status', 'Dipinjam') 
                                ->count();

            $totalDenda = Peminjaman::where('anggota_id', $anggota->id)
                                ->sum('denda');
                                    
            $sudahKembali = Peminjaman::where('anggota_id', $anggota->id)
                                ->where('status', 'Kembali') 
                                ->count();
        }

        return view('anggota.dashboard', compact('peminjamanAktif', 'totalDenda', 'sudahKembali'));
    }
}
