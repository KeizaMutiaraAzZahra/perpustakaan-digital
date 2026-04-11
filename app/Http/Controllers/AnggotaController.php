<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Jangan lupa import ini!

class AnggotaController extends Controller
{
    /**
     * Tampilan untuk Petugas (Read)
     */
    public function index(Request $request)
    {
        // Gunakan model Anggota, bukan User
        $query = Anggota::query();

        if ($request->cari) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        $anggota = $query->latest()->paginate(10)->withQueryString();

        return view('petugas.anggota.index', compact('anggota'));
    }

    /**
     * Tampilan untuk Kepala Perpustakaan
     */
    public function kepala(Request $request)
    {
        $query = Anggota::with('user');

        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        $anggota = $query->latest()->paginate(10)->withQueryString();

        return view('kepala.data-anggota', compact('anggota'));
    }

    public function create()
    {
        return view('petugas.anggota.create');
    }

    /**
     * Simpan Data (Create)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_telepon' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        // Kita buat Akun di tabel 'users'
        $user = User::create([
            'name'     => $request->nama,
            'username' => $request->username,
            // Kuncinya di sini: Email dibuat otomatis dari username + @perpus.com
            'email'    => $request->username . '@perpus.com', 
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
            'status'   => 'aktif',
        ]);

        // Baru simpan ke tabel 'anggotas' pake user_id
        Anggota::create([
            'user_id'    => $user->id,
            'nama'       => $request->nama,
            'kelas'      => $request->kelas,
            'jurusan'    => $request->jurusan,
            'no_telepon' => $request->no_telepon,
            'status'     => 'Aktif',
        ]);

        return redirect()->route('petugas.anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }
    public function edit($id) // Tambahkan parameter $id
    {
        $anggota = Anggota::findOrFail($id);
        return view('petugas.anggota.edit', compact('anggota'));
    }

    /**
     * Update Data
     */
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $user = User::findOrFail($anggota->user_id);

        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_telepon' => 'required',
        ]);

        // Update data login di tabel USERS
        $userData = [
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->username . '@perpus.com', // Update email otomatis
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update data profil di tabel ANGGOTAS
        $anggota->update([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_telepon' => $request->no_telepon,
            'status' => $request->status ?? $anggota->status,
        ]);

        return redirect()->route('petugas.anggota.index')->with('success', 'Data berhasil diupdate!');
    }
    /**
     * Hapus Data (Delete)
     */
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('petugas.anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}