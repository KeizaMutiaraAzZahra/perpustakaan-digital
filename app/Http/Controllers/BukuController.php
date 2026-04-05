<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib ditambahkan agar Storage:: bekerja

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::latest()->get();
        return view('petugas.buku.index', compact('buku'));
    }

    public function kepala()
    {
        $buku = Buku::latest()->get();
        return view('kepala.data-buku', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'stok'         => 'required|numeric',
            'kategori'     => 'required|in:Pelajaran,Novel,Komik',
            'gambar'       => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()->route('petugas.buku.index')->with('success', 'Buku Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        return view('petugas.buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        return view('petugas.buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'stok'         => 'required|numeric',
            'kategori'     => 'required|in:Pelajaran,Novel,Komik',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }
        $buku->update($data);

        return redirect()->route('petugas.buku.index')->with('success', 'Buku Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
       if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
            Storage::disk('public')->delete($buku->gambar);
        }
        $buku->delete();

        return redirect()->route('petugas.buku.index')->with('success', 'Buku Berhasil Dihapus!');
    }
}