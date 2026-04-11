<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman (Data Masuk dari Anggota) - PETUGAS
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%");
            })->orWhereHas('buku', function($q) use ($cari) {
                $q->where('judul', 'like', "%$cari%");
            });
        }

        // Pakai paginate agar tidak berat
        $peminjaman = $query->latest()->paginate(10)->withQueryString();

        return view('petugas.peminjaman', compact('peminjaman'));
    }

    /**
     * Konfirmasi Peminjaman oleh Petugas
     */
    public function konfirmasi($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_pinjam' => now(),
            'jatuh_tempo' => now()->addDays(7), 
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil dikonfirmasi!');
    }

    /**
     * Daftar Pengembalian - PETUGAS
     */
    public function pengembalian(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])->where('status', 'Kembali');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%");
            })->orWhereHas('buku', function($q) use ($cari) {
                $q->where('judul', 'like', "%$cari%");
            });
        }

        $pengembalian = $query->latest('updated_at')->paginate(10)->withQueryString();

        return view('petugas.pengembalian', compact('pengembalian'));
    }

    /**
     * Daftar Denda - PETUGAS
     */
    public function denda(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])->where('denda', '>', 0);

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%");
            });
        }

        $denda = $query->latest('tanggal_kembali')->paginate(10)->withQueryString();

        return view('petugas.denda', compact('denda'));
    }

    /**
     * FITUR BARU: Bayar Denda (Tandai Lunas) - PETUGAS
     */
    public function bayarDenda($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Cukup set denda ke 0
        $peminjaman->update(['denda' => 0]);

        return redirect()->back()->with('success', 'Denda berhasil ditandai lunas!');
    }

    /**
     * Simpan Pengajuan Pinjam - ANGGOTA
     */
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
     * Data Peminjaman Aktif & Riwayat - ANGGOTA
     */
    public function anggota()
    {
        $userId = auth()->id();

        $peminjamanAktif = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereIn('status', ['Diproses', 'Dipinjam', 'Terlambat'])
            ->latest()
            ->paginate(5, ['*'], 'p_aktif'); // Paginate dengan nama unik

        $riwayatPeminjaman = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', 'Kembali')
            ->latest()
            ->paginate(5, ['*'], 'p_riwayat');

        return view('anggota.data-peminjaman', compact('peminjamanAktif', 'riwayatPeminjaman'));
    }

    /**
     * Data Denda - ANGGOTA
     */
    public function dendaAnggota()
    {
        $userId = auth()->id();
        $query = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('denda', '>', 0);

        $totalTagihan = $query->sum('denda');
        $daftarDenda = $query->paginate(10);

        return view('anggota.data-denda', compact('daftarDenda', 'totalTagihan'));
    }

    /**
     * Form Pengembalian - ANGGOTA
     */
    public function showForm($id) 
    {
        $data = Peminjaman::with('buku')->findOrFail($id);
        return view('anggota.form-pengembalian', compact('data'));
    }

    /**
     * Proses Pengembalian - ANGGOTA
     */

    public function pengembalianAnggota(Request $request)
    {
        $userId = auth()->id();
        $keyword = $request->keyword;

        $pengembalian = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', 'Kembali') 
            ->when($keyword, function($query) use ($keyword) {
                $query->whereHas('buku', function($q) use ($keyword) {
                    $q->where('judul', 'like', "%$keyword%");
                });
            })
            ->latest('tanggal_kembali')
            ->paginate(10) // Tambahkan paginate biar seragam
            ->withQueryString();

        return view('anggota.data-pengembalian', compact('pengembalian'));
    }

    public function prosesPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $denda = 0;
        
        if (now()->gt($peminjaman->jatuh_tempo)) {
            $hariTerlambat = now()->diffInDays($peminjaman->jatuh_tempo);
            $denda = $hariTerlambat * 1000; 
        }

        $peminjaman->update([
            'status' => 'Kembali',
            'tanggal_kembali' => now(),
            'denda' => $denda,
        ]);

        return redirect()->route('anggota.data-pengembalian')
                         ->with('success', 'Buku berhasil dikembalikan!');
    }
}