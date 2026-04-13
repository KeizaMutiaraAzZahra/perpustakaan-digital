<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $buku = Buku::find($peminjaman->buku_id);

        if ($buku) {
            if ($buku->stok < $peminjaman->jumlah) {
                return redirect()->back()->with('error', 'Stok tidak cukup!');
            }
            // DI SINI TEMPAT NGURANGIN STOK YANG BENER
            $buku->decrement('stok', $peminjaman->jumlah); 
        }

        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_pinjam' => now(),
            'jatuh_tempo' => now()->addDays(7), 
        ]);

        return redirect()->back()->with('success', 'Konfirmasi berhasil!');
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
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        $jumlahPinjam = $request->jumlah;

        if ($buku->stok < $jumlahPinjam) {
            return back()->with('error', 'Stok buku tidak mencukupi!');
        }

        $anggota = Anggota::where('user_id', auth()->id())->first();

        if (!$anggota) {
            return back()->with('error', 'Data anggota Anda tidak ditemukan.');
        }

        Peminjaman::create([
            'anggota_id'     => $anggota->id,
            'buku_id'        => $buku->id,
            'jumlah'         => $jumlahPinjam,
            'status'         => 'Diproses',
            'tanggal_pinjam' => now(),
            'jatuh_tempo'    => now()->addDays(7), 
        ]);


        return redirect()->route('anggota.data-peminjaman')->with('success', 'Permintaan pinjam berhasil dikirim!');
    }

    /**
     * Data Denda - ANGGOTA
     */
    public function dendaAnggota(Request $request)
    {
        $userId = auth()->id();
        $query = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('denda', '>', 0);

        if ($request->filled('cari')) {
            $search = $request->cari;
            $query->whereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            });
        }

        
        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status', $request->status);
        }

        $daftarDenda = $query->latest()->paginate(10)->withQueryString();
        
        $totalTagihan = Peminjaman::whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('denda', '>', 0)
            ->sum('denda');

        return view('anggota.data-denda', compact('daftarDenda', 'totalTagihan'));
    }

    public function updateDenda($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Set denda jadi 0, dan statusnya kita ubah ke 'Kembali' 
        // agar tidak muncul lagi di daftar tagihan denda
        $peminjaman->update([
            'denda' => 0,
            'status' => 'Kembali' 
        ]);

        return redirect()->back()->with('success', 'Denda berhasil dibayar lunas!');
    }
        /**
     * Form Pengembalian - ANGGOTA
     */
    public function showForm($id) 
    {
        $data = Peminjaman::with('buku')->findOrFail($id);
        
        // Hitung denda sementara untuk ditampilkan di layar
        $sekarang = now()->startOfDay();
        $jatuhTempo = Carbon::parse($data->jatuh_tempo)->startOfDay();
        $denda = 0;

        if ($sekarang->gt($jatuhTempo)) {
            $hariTerlambat = $jatuhTempo->diffInDays($sekarang);
            $denda = $hariTerlambat * 5000; // Tarif 5000 per hari
        }

        return view('anggota.form-pengembalian', compact('data', 'denda'));
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
            // UBAH DISINI: Tambahkan status 'Terlambat' agar muncul di riwayat
            ->whereIn('status', ['Kembali', 'Terlambat']) 
            ->when($keyword, function($query) use ($keyword) {
                $query->whereHas('buku', function($q) use ($keyword) {
                    $q->where('judul', 'like', "%$keyword%");
                });
            })
            ->latest('tanggal_kembali')
            ->paginate(10)
            ->withQueryString();

        return view('anggota.data-pengembalian', compact('pengembalian'));
    }

    public function prosesPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $sekarang = now()->startOfDay(); 
        $jatuhTempo = Carbon::parse($peminjaman->jatuh_tempo)->startOfDay();

        $denda = 0;
        $status = 'Kembali';

        // Logika Hitung Denda Rp 5.000
        if ($sekarang->gt($jatuhTempo)) {
            $hariTerlambat = $jatuhTempo->diffInDays($sekarang);
            $denda = $hariTerlambat * 5000;
            $status = 'Terlambat';
        }

        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok', $peminjaman->jumlah); 
        }

        $peminjaman->update([
            'status' => $status,
            'tanggal_kembali' => now(), 
            'denda' => $denda,
        ]);

        return redirect()->route('anggota.data-pengembalian')
                         ->with('success', 'Buku berhasil dikembalikan dengan status: ' . $status);
    }

    public function anggota()
    {
        $userId = auth()->id();

        $peminjamanAktif = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereIn('status', ['Diproses', 'Dipinjam', 'Terlambat'])
            ->latest()
            ->paginate(5, ['*'], 'p_aktif');

        $riwayatPeminjaman = Peminjaman::with('buku')
            ->whereHas('anggota', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', 'Kembali')
            ->latest()
            ->paginate(5, ['*'], 'p_riwayat');

        return view('anggota.data-peminjaman', compact('peminjamanAktif', 'riwayatPeminjaman'));
    }
}