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
        $query = Peminjaman::with(['anggota', 'buku'])
            ->whereIn('status', ['Dipinjam','Menunggu Konfirmasi', 'Kembali', 'Terlambat']);
       
        if ($request->filled('cari')) {
            $cari = $request->cari;
            
            $query->where(function($q) use ($cari) {
                $q->whereHas('anggota', function($queryAnggota) use ($cari) {
                    $queryAnggota->where('nama', 'like', "%$cari%");
                })
                ->orWhereHas('buku', function($queryBuku) use ($cari) {
                    $queryBuku->where('judul', 'like', "%$cari%");
                });
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
        $query = Peminjaman::with(['anggota', 'buku'])
            ->where('status_denda', '!=', 'lunas');;

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

        $peminjaman->update([
            'status'       => 'Selesai',      
            'denda'        => 0,             
            'status_denda' => 'lunas',        
        ]);

        return back()->with('success', 'Denda dilunasi dan status menjadi Selesai');
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

        $totalDipinjam = Peminjaman::where('anggota_id', $anggota->id)
            ->whereNull('tanggal_kembali')
            ->sum('jumlah');

        $batasMaksimal = 3;

        if (($totalDipinjam + $jumlahPinjam) > $batasMaksimal) {
            return back()->with('error', 'Maksimal peminjaman hanya 3 buku!');
        }

        Peminjaman::create([
            'anggota_id'     => $anggota->id,
            'buku_id'        => $buku->id,
            'jumlah'         => $jumlahPinjam,
            'status'         => 'Diproses',
            'tanggal_pinjam' => now(),
            'jatuh_tempo'    => now()->addDays(7), 
        ]);

        return redirect()->route('anggota.data-peminjaman')
            ->with('success', 'Permintaan pinjam berhasil dikirim!');
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

        // SEARCH
        if ($request->filled('cari')) {
            $search = $request->cari;
            $query->whereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            });
        }

        $allDenda = $query->latest()->get(); 

        // 2. HITUNG ULANG & TRANSFORM
        $allDenda->transform(function ($item) {
            $jatuhTempo = strtotime($item->jatuh_tempo);
            // Jika status sudah Kembali/Lunas, pakai tanggal_kembali. Jika belum, pakai waktu sekarang.
            $kembali = $item->tanggal_kembali 
                ? strtotime($item->tanggal_kembali) 
                : time();

            $selisih = ($kembali - $jatuhTempo) / (60 * 60 * 24);
            $hari = $selisih > 0 ? floor($selisih) : 0;

            $dendaPerHari = 5000;
            $item->hari_terlambat = $hari;
            $item->total_denda = $hari * $dendaPerHari;

            return $item;
        });

        $tagihanAktif = $allDenda->whereIn('status', ['Terlambat', 'Belum Bayar']);
        
        // Riwayat: Yang statusnya sudah 'Kembali', 'Lunas', atau 'Selesai'
        $riwayatDenda = $allDenda->whereIn('status', ['Kembali', 'Lunas', 'Selesai']);

        $totalTagihan = $tagihanAktif->sum('total_denda');

        return view('anggota.data-denda', compact('tagihanAktif', 'riwayatDenda', 'totalTagihan'));
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
            // TAMBAHKAN 'Menunggu Konfirmasi' agar data yang baru diklik muncul di sini
            ->whereIn('status', ['Kembali', 'Terlambat', 'Menunggu Konfirmasi']) 
            ->when($keyword, function($query) use ($keyword) {
                $query->whereHas('buku', function($q) use ($keyword) {
                    $q->where('judul', 'like', "%$keyword%");
                });
            })
            ->latest('updated_at') // Pakai updated_at supaya yang baru dikonfirmasi naik ke atas
            ->paginate(10)
            ->withQueryString();

        return view('anggota.data-pengembalian', compact('pengembalian'));
    }

    public function prosesPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'Diproses') {
            return back()->with('error', 'Buku belum dipinjam!');
        }

        // ✅ HANYA REQUEST KE PETUGAS
        $peminjaman->update([
            'status' => 'Menunggu Konfirmasi',
            'tanggal_kembali' => now(),
        ]);

        return redirect()->route('anggota.data-pengembalian')
            ->with('success', 'Menunggu konfirmasi petugas');
    }

    public function konfirmasiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $sekarang = now()->startOfDay();
        $jatuhTempo = \Carbon\Carbon::parse($peminjaman->jatuh_tempo)->startOfDay();

        $denda = 0;
        $status = 'Kembali';
        $status_denda = null; 

        if ($sekarang->gt($jatuhTempo)) {
            $hariTerlambat = $jatuhTempo->diffInDays($sekarang);
            $denda = $hariTerlambat * 5000;
            $status = 'Terlambat';
            $status_denda = 'belum lunas'; // Ini yang bikin data muncul di laporan denda!
        }

        $buku = \App\Models\Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok', $peminjaman->jumlah);
        }

        $peminjaman->status = $status;
        $peminjaman->denda = $denda;
        $peminjaman->tanggal_kembali = now();
        $peminjaman->save();

        return back()->with('success', 'Pengembalian berhasil dikonfirmasi!');
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

    public function showForm($id) 
    {
        $data = Peminjaman::with('buku')->findOrFail($id);

        $sekarang = now()->startOfDay();
        $jatuhTempo = \Carbon\Carbon::parse($data->jatuh_tempo)->startOfDay();

        $denda = 0;

        if ($sekarang->gt($jatuhTempo)) {
            $hariTerlambat = $jatuhTempo->diffInDays($sekarang);
            $denda = $hariTerlambat * 5000;
        }

        return view('anggota.form-pengembalian', compact('data', 'denda'));
    }
}