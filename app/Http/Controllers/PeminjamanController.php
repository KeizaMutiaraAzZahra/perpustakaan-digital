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

    /**
     * Fungsi Aksi: Konfirmasi Peminjaman (Tombol "Konfirmasi" di Tabel)
     */
    public function konfirmasi(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($request->aksi == 'setuju') {
            // Logika: Saat disetujui, tgl pinjam & jatuh tempo baru terisi otomatis
            $peminjaman->update([
                'status' => 'dipinjam',
                'tanggal_pinjam' => Carbon::now(),
                'jatuh_tempo' => Carbon::now()->addDays(7), // Otomatis 7 hari
            ]);

            // Stok buku berkurang
            $peminjaman->buku()->decrement('stok');

            return redirect()->back()->with('success', 'Peminjaman telah disetujui!');
        }

        if ($request->aksi == 'tolak') {
            $peminjaman->update(['status' => 'ditolak']);
            return redirect()->back()->with('error', 'Peminjaman ditolak.');
        }
    }

    /**
     * Fungsi Aksi: Pengembalian (Jika mau ditambahkan tombol "Kembalikan")
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
}