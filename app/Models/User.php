<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role', // 'kepala', 'petugas', 'anggota'
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- HELPER UNTUK CEK ROLE ---

    /**
     * Cek apakah user adalah Kepala Perpustakaan
     */
    public function isKepala()
    {
        return $this->role === 'kepala';
    }

    /**
     * Cek apakah user adalah Petugas
     */
    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    /**
     * Cek apakah user adalah Anggota
     */
    public function isAnggota()
    {
        return $this->role === 'anggota';
    }
}