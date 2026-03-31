@extends('layouts.main')

@section('title', 'TambahPetugas')

@section('content')
    <main class ="frame-main">
        <section class="tambah-petugas">
            <h1 class="title">Tambah Petugas</h1>

                <form action="{{ route('petugas.store') }}" method="POST" class="form">
                    @csrf
      
                    <div class="form-group">
                        <label>Nama</label>
                        <input 
                            type="text" 
                            name="nama" 
                            placeholder="Masukkan nama" 
                            required>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input 
                            type="text" 
                            name="alamat" 
                            placeholder="Masukkan alamat"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="P">Perempuan</option>
                            <option value="L">Laki-laki</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>No Telepon</label>
                        <input 
                            type="tel" 
                            name="no_telepon" 
                            placeholder="Masukkan nomor"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input 
                            type="text" 
                            name="username" 
                            placeholder="Masukkan username"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Masukkan password"
                            required>
                    </div>

                    <div class="button-group">
                        <button type="button" class="btn batal">Batal</button>
                        <button type="submit" class="btn simpan">Simpan</button>
                    </div>

                </form>
        </section>
    </main>
@endsection