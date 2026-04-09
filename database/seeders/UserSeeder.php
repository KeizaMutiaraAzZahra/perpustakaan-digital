<?php

namespace Database\Seeders;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
            User::create([
            'name'     => 'Kepala Perpustakaan',
            'username' => 'kepalaperpustakaan',
            'email'    => 'kepala@gmail.com',
            'password' => Hash::make('000000'),
            'role'     => 'kepala',
        ]);
        
            $userPetugas = User::create([
            'name'     => 'Petugas Perpustakaan',
            'username' => 'petugasperpustakaan',
            'email'    => 'petugas@gmail.com',
            'password' => Hash::make('111111'),
            'role'     => 'petugas',
        ]);

        Petugas::create([
            'user_id' => $userPetugas->id,
            'nama' => 'Petugas Perpustakaan',
            'alamat' => 'Bandung',
            'jenis_kelamin' => 'L',
            'no_telepon' => '08123456789',
        ]);

    }
}