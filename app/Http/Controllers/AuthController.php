<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role == 'kepala') {
                return redirect()->route('kepala.dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect()->route('petugas.dashboard');
            } elseif ($user->role == 'anggota') {
                return redirect()->route('anggota.dashboard');
            }
        }

        return view('auth.login');
    }

    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // REDIRECT BERDASARKAN ROLE
            if ($user->role == 'kepala') {
                return redirect()->route('kepala.dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect()->route('petugas.dashboard');
            } elseif ($user->role == 'anggota') {
                return redirect()->route('anggota.dashboard');
            }

            // Jika role tidak dikenali (keamanan tambahan)
            Auth::logout();
            return redirect('/login')->with('error', 'Akses ditolak: Role tidak dikenali.');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' butuh input password_confirmation di view
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota', // Default registrasi biasanya untuk Anggota, bukan Kepala
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}