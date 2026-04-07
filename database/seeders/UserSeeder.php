<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Kepala Perpustakaan',
            'username' => 'kepalaperpustakaan',
            'email'    => 'kepala@gmail.com',
            'password' => Hash::make('000000'), // Ganti sesuai keinginan
            'role'     => 'kepala',
        ]);
        User::create([
            'name'     => 'Petugas Perpustakaan',
            'username' => 'petugasperpustakaan',
            'email'    => 'petugas@gmail.com',
            'password' => Hash::make('111111'), // Ganti sesuai keinginan
            'role'     => 'petugas',
        ]);
    }
}