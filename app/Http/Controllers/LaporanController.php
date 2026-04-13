<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

    public function pengembalian()
    {
        $pengembalian = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'Kembali')
            ->whereNotNull('tanggal_kembali') 
            ->latest()
            ->get();

        return view('kepala.laporan.pengembalian', compact('pengembalian'));
    }

    public function cetak(Request $request)
    {
        $status = $request->status; // Dipinjam, Kembali, Denda
        $query = Peminjaman::with(['anggota', 'buku']);

        if ($status == 'Denda') {
            $query->where('denda', '>', 0);
        } else {
            $query->where('status', $status);
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('kepala.laporan-pdf', compact('data', 'status'));
        
        // Pakai stream biar Pak Kepala bisa lihat dulu sebelum diprint
        return $pdf->stream('Laporan_' . $status . '.pdf');
    }
}
