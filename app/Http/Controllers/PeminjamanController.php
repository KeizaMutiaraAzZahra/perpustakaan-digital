<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman (Data yang masuk dari Anggota)
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        // Fitur Cari berdasarkan Nama Anggota atau Judul Buku
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%");
            })->orWhereHas('buku', function($q) use ($cari) {
                $q->where('judul', 'like', "%$cari%");
            });
        }

        $peminjaman = $query->latest()->get();

        return view('petugas.peminjaman', compact('peminjaman'));
    }


    public function store(Request $request)
    {
        $anggotaId = auth()->user()->anggota->id;

        $adaPeminjaman = Peminjaman::where('anggota_id', $anggotaId)
            ->where('buku_id', $request->buku_id)
            ->whereIn('status', ['Diproses', 'Dipinjam'])
            ->exists();

        if ($adaPeminjaman) {
            return redirect()->back()->with('error', 'Kamu sudah mengajukan buku ini.');
        }

        Peminjaman::create([
            'anggota_id' => $anggotaId,
            'buku_id'    => $request->buku_id,
            'status'     => 'Diproses', 
            'tanggal_pinjam' => now(),
            'jatuh_tempo'    => now()->addDays(7),
        ]);

        return redirect()->back()->with('success', 'Berhasil diajukan!');
    }
    /**
     */
    public function pengembalian(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])->where('status', 'kembali');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%");
            })->orWhereHas('buku', function($q) use ($cari) {
                $q->where('judul', 'like', "%$cari%");
            });
        }

        $pengembalian = $query->latest('updated_at')->get();

        return view('petugas.pengembalian', compact('pengembalian'));
    }

    public function denda(Request $request)
    {
        // Ambil data yang dendanya lebih besar dari 0
        $query = Peminjaman::with(['anggota', 'buku'])->where('denda', '>', 0);

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%");
            });
        }

        $denda = $query->latest('tanggal_kembali')->get();

        return view('petugas.denda', compact('denda'));
    }

    public function anggota()
    {
        $userId = auth()->id();

        // Ambil peminjaman yang sedang aktif (Menunggu konfirmasi atau sedang dibawa)
        $peminjamanAktif = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereIn('status', ['Diproses', 'Dipinjam', 'Terlambat'])
            ->latest()
            ->get();

        // Ambil yang sudah dikembalikan
        $riwayatPeminjaman = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', 'Kembali')
            ->latest()
            ->get();

        return view('anggota.data-peminjaman', compact('peminjamanAktif', 'riwayatPeminjaman'));
    }

    public function pengembalianAnggota(Request $request)
    {
        $userId = auth()->id();
        $keyword = $request->keyword;

        $pengembalian = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', 'kembali') 
            ->when($keyword, function($query) use ($keyword) {
                $query->whereHas('buku', function($q) use ($keyword) {
                    $q->where('judul', 'like', "%$keyword%");
                });
            })
            ->latest('tanggal_kembali')
            ->get();

        return view('anggota.data-pengembalian', compact('pengembalian'));
    }

    public function dendaAnggota()
    {
        $userId = auth()->id();
        $daftarDenda = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('denda', '>', 0)
            ->get();

        $totalTagihan = $daftarDenda->sum('denda');

        // GANTI 'anggota.denda' MENJADI 'anggota.data-denda'
        return view('anggota.data-denda', compact('daftarDenda', 'totalTagihan'));
    }
}