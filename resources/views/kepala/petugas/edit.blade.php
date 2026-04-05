@extends('kepala.layouts.main')

@section('title', 'Edit Petugas')

@section('content')
<main class ="frame-main">
        <section class="tambah-petugas">
            <h1 class="title">Edit Petugas</h1>

                <form action="{{ route('kepala.petugas.update', $petugas->id) }}" method="POST" class="form">
                    @csrf
                    @method('PUT')
      
                    <div class="form-group">
                        <label>Nama</label>
                        <input 
                            type="text" 
                            name="nama"
                            placeholder="Masukkan nama"
                            value="{{ old('nama', $petugas->nama) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input 
                            type="text" 
                            name="alamat"
                            placeholder="Masukkan alamat"
                            value="{{ old('alamat', $petugas->alamat) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                        <option value="P" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'P' ? 'selected' : '' }} >Perempuan</option>
                        <option value="L" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'L' ? 'selected' : '' }} >Laki-laki</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>No Telepon</label>
                        <input 
                            type="tel" 
                            name="no_telepon" 
                            placeholder="Masukkan nomor"
                            value="{{ old('no_telepon', $petugas->no_telepon) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input 
                            type="text" 
                            name="username"
                            placeholder="Masukkan username"
                            value="{{ old('username', $petugas->username) }}" 
                            required>
                    </div>

                    <div class="form-group">
                        <label>Password (kosongkan jika tidak ingin ganti)</label>
                        <input 
                            type="password"
                            name="password">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                       <option value="aktif" 
                            {{ old('status', $petugas->status) == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
    
                        <option value="nonaktif" 
                            {{ old('status', $petugas->status) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                        </select>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('kepala.petugas.index') }}" class="btn batal">Batal</a>
                        <button type="submit" class="btn simpan">Simpan</button>
                    </div>

                </form>
        </section>
    </main>
@endsection