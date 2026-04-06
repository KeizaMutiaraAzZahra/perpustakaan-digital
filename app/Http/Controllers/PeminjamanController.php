<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman dengan fitur pencarian
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        // Fitur Cari berdasarkan Nama Anggota atau Judul Buku
        if ($request->has('cari') && $request->cari != '') {
            $cari = $request->cari;
            $query->whereHas('anggota', function($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%");
            })->orWhereHas('buku', function($q) use ($cari) {
                $q->where('judul', 'like', "%$cari%");
            });
        }

        $peminjaman = $query->latest()->get();

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Form Input Pinjam
     */
    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::where('stok', '>', 0)->get(); // Hanya buku yang ada stoknya
        return view('petugas.peminjaman.create', compact('anggota', 'buku'));
    }

    /**
     * Simpan Data Peminjaman
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        // Hitung Jatuh Tempo otomatis (misal 7 hari dari tanggal pinjam)
        $tgl_pinjam = Carbon::parse($request->tanggal_pinjam);
        $jatuh_tempo = $tgl_pinjam->addDays(7);

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo' => $jatuh_tempo,
            'status' => 'Dipinjam',
            'denda' => 0
        ]);

        // Kurangi stok buku setelah dipinjam
        Buku::find($request->buku_id)->decrement('stok');

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Peminjaman Berhasil Dicatat');
    }

    /**
     * Detail Peminjaman (Halaman yang ada di desain Figma kamu)
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);
        return view('petugas.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Update Status Kembali (Logika Pengembalian)
     */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $tgl_kembali = Carbon::now();
        $jatuh_tempo = Carbon::parse($peminjaman->jatuh_tempo);
        
        $denda = 0;
        if ($tgl_kembali->gt($jatuh_tempo)) {
            $selisih_hari = $tgl_kembali->diffInDays($jatuh_tempo);
            $denda = $selisih_hari * 1000; // Misal denda 1000 per hari
        }

        $peminjaman->update([
            'tanggal_kembali' => $tgl_kembali,
            'status' => 'Kembali',
            'denda' => $denda
        ]);

        // Kembalikan stok buku
        $peminjaman->buku()->increment('stok');

        return redirect()->back()->with('success', 'Buku telah dikembalikan');
    }
}