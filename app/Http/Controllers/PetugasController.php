<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugas = Petugas::orderBy('id', 'asc')->get();
        return view('petugas.index', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required',
            'username' => 'required|unique:petugas',
            'password' => 'required|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);

        Petugas::create($data);

        return redirect()->route('petugas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Petugas $petugas)
    {
        return view('petugas.show', compact('petugas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petugas $petugas)
    {
        return view('petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petugas $petugas)
    {
        $data = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required',
            'username' => 'required|unique:petugas,username,' . $petugas->id,
            'password' => 'nullable|min:6'
        ]);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $petugas->update($data);

        return redirect()->route('petugas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petugas $petugas)
    {
        $petugas->delete();
        return redirect()->route('petugas.index');
    }
}
