<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('buku', function ($q2) use ($search) {
                    $q2->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('anggota', function ($q2) use ($search) {
                    $q2->where('nama', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled ('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [
            request('start_date'),
            request('end_date')
        ]);
        }

        $peminjaman = $query->latest()->get();

        return view('kepala.laporan.peminjaman', compact('peminjaman'));
    }
        
    public function denda(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])
            ->where(function($q) {
                $q->where('denda', '>', 0)
                ->orWhere('status', 'Selesai');
            });

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('buku', function ($q2) use ($search) {
                    $q2->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('anggota', function ($q2) use ($search) {
                    $q2->where('nama', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_kembali', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $denda = $query->latest()->paginate(10);
        
        return view('kepala.laporan.denda', compact('denda'));
    }

    public function pengembalian(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'Kembali')
            ->whereNotNull('tanggal_kembali');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('buku', function ($q2) use ($search) {
                    $q2->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('anggota', function ($q2) use ($search) {
                    $q2->where('nama', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_kembali', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $pengembalian = $query->latest()->get();

        return view('kepala.laporan.pengembalian', compact('pengembalian'));
    }

    public function cetak(Request $request)
    {
        $status = $request->status;

        $query = Peminjaman::with(['anggota', 'buku']);

        if ($status == 'Denda') {
        $query->where(function ($q) {
            $q->where('denda', '>', 0)
            ->orWhere('status', 'Selesai');
        });

        $view = 'kepala.laporan.denda-pdf';

        } elseif ($status == 'Pengembalian') {
            $query->where('status', 'Kembali')
                ->whereNotNull('tanggal_kembali');
            $view = 'kepala.laporan.pengembalian-pdf';

        } else {
        
            $view = 'kepala.laporan.peminjaman-pdf';
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('anggota', function ($q2) use ($request) {
                    $q2->where('nama', 'like', '%' . $request->search . '%');
                })
            ->orWhereHas('buku', function ($q2) use ($request) {
                $q2->where('judul', 'like', '%' . $request->search . '%');
            });
        });
    }

        if ($request->start_date && $request->end_date) {

          
            if ($status == 'Pengembalian') {
                $query->whereBetween('tanggal_kembali', [
                    $request->start_date,
                    $request->end_date
                ]);
            } else {
               
                $query->whereBetween('tanggal_pinjam', [
                    $request->start_date,
                    $request->end_date
                ]);
            }
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView($view, compact('data'));

        return $pdf->stream('Laporan_' . $status . '.pdf');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $peminjaman = Peminjaman::where('judul', 'LIKE', "%$keyword%")
                    ->orWhere('Anggota', 'LIKE', "%$keyword%")
                    ->orWhere('kategori', 'LIKE', "%$keyword%") 
                    ->latest()
                    ->paginate(8) 
                    ->withQueryString();

        return view('kepala.laporan.peminjaman', compact('peminjaman'));
    }
}
