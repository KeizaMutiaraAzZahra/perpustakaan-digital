<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
      
        $viewPath = $user->role . '.profile.index';
        
        if (view()->exists($viewPath)) {
            return view($viewPath, compact('user'));
        }
        abort(403);
    }

    public function edit()
    {
        $user = Auth::user();

        $viewPath = $user->role . '.profile.edit';

        if (view()->exists($viewPath)) {
            return view($viewPath, compact('user'));
        }
        abort(403);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'     => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ];

        if ($user->role == 'petugas') {
            $rules['alamat'] = 'required';
            $rules['no_telp'] = 'required';
            $rules['jenis_kelamin'] = 'required|in:L,P,Laki-laki,Perempuan';
        } elseif ($user->role == 'anggota') {
            $rules['kelas'] = 'required';
            $rules['jurusan'] = 'required';
            $rules['no_telepon'] = 'required';
        }

        $request->validate($rules);

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

       
        if ($user->role == 'petugas') {
            
            \DB::table('petugas')->where('user_id', $user->id)->update([
                'alamat'        => $request->alamat,
                'no_telepon'    => $request->no_telp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'updated_at'    => now(),
            ]);
        } 
        elseif ($user->role == 'anggota') {
            \DB::table('anggotas')->where('user_id', $user->id)->update([
                'nama'        => $request->name, 
                'kelas'       => $request->kelas,
                'jurusan'     => $request->jurusan,
                'no_telepon'  => $request->no_telepon,
                'updated_at'  => now(),
            ]);
        }

        return redirect()->route($user->role . '.profile.index')->with('success', 'Profil Berhasil Diperbarui!');
    }
}