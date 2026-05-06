<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::with('user')->get();
        return view('kepala.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('kepala.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->username . '@mail.com', // AUTO EMAIL
            'password' => Hash::make($request->password),
            'role' => 'petugas',
            'status' => 'aktif'
        ]);

        Petugas::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('kepala.petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan');
    }

    public function show($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('kepala.petugas.show', compact('petugas'));
    }

    public function edit($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('kepala.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $petugas->user_id,
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required',
        ]);

        $petugas->user->update([
            'name' => $request->nama,
            'username' => $request->username,
        ]);

        $petugas->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('kepala.petugas.index');
    }

   public function destroy($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        $petugas->user->delete(); 

        return redirect()->route('kepala.petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        $user = $petugas->user;
        $user->status = ($user->status == 'aktif') ? 'nonaktif' : 'aktif';
        $user->save();

        return back();
    }
}