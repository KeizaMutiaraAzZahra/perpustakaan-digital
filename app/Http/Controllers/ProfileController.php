<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mengarahkan ke view index sesuai role
        $viewPath = $user->role . '.profile.index';
        
        if (view()->exists($viewPath)) {
            return view($viewPath, compact('user'));
        }
        abort(403);
    }

    public function edit()
    {
        $user = Auth::user();
        // Mengarahkan ke view edit sesuai role
        $viewPath = $user->role . '.profile.edit';

        if (view()->exists($viewPath)) {
            return view($viewPath, compact('user'));
        }
        abort(403);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan,L,P',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            // Validasi tambahan khusus anggota
            'kelas' => $user->role == 'anggota' ? 'nullable' : '',
            'jurusan' => $user->role == 'anggota' ? 'nullable' : '',
        ]);

        // 2. Update tabel USERS (Data Utama)
        $user->update([
            'name' => $request->name,
        ]);

        // 3. Logika Percabangan Role
        if ($user->role == 'petugas' || $user->role == 'kepala') {
            // Update ke tabel PETUGAS
            // Kita pakai DB builder supaya cepat karena kita belum buat Model Petugas-nya
            \DB::table('petugas')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'nama' => $request->name,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => substr($request->jenis_kelamin, 0, 1), // Ambil 'L' atau 'P' sesuai DB kamu
                    'no_telepon' => $request->no_telp,
                    'updated_at' => now(),
                ]
            );
        } elseif ($user->role == 'anggota') {
            // Update ke tabel ANGGOTAS
            \DB::table('anggotas')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'nama' => $request->name,
                    'kelas' => $request->kelas,
                    'jurusan' => $request->jurusan,
                    'no_telepon' => $request->no_telp,
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->route($user->role . '.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}