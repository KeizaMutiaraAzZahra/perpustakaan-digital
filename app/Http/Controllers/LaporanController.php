<?php

namespace App\Http\Controllers;

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
     
    public function denda()
    {
        // Ambil semua data yang denda-nya bukan 0
        $denda = Peminjaman::with(['anggota', 'buku'])
                    ->where('denda', '>', 0) 
                    ->latest()
                    ->paginate(10);

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
        $status = $request->status;
        $query = Peminjaman::with(['anggota.user', 'buku']);

        if ($status == 'Denda') {
            // Ambil peminjaman yang ada dendanya saja
            $query->where('denda', '>', 0)->orWhere('status_denda', 'lunas');
            $view = 'kepala.laporan.denda-pdf'; 
        } elseif ($status == 'Pengembalian') {
            $query->where('status', 'Kembali');
            $view = 'kepala.laporan.pengembalian-pdf';
        } else {
            $query->where('status', 'Dipinjam');
            $view = 'kepala.laporan.peminjaman-pdf';
        }

        $data = $query->latest()->get();
        $pdf = Pdf::loadView($view, compact('data'));

        return $pdf->stream('Laporan_' . $status . '.pdf');
    }
}
