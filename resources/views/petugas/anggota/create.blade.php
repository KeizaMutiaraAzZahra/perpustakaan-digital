@extends('petugas.layouts.main')

@section('title', 'Tambah Buku')

@section('content')
<main class="tambah-anggota-petugas">
    <div class="form-container">
        <div class="form-header">
            <h2>Tambah Anggota</h2>
        </div>

        <form action="{{ route('petugas.anggota.store') }}" method="POST" class="form-body">
            @csrf
            
            <div class="input-group">
                <label for="nama">Nama :</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="input-group">
                <label for="kelas">Kelas :</label>
                <input type="text" id="kelas" name="kelas" required>
            </div>

            <div class="input-group">
                <label for="jurusan">Jurusan :</label>
                <select id="jurusan" name="jurusan">
                    <option value="PPLG">PPLG</option>
                    <option value="AKL">AKL</option>
                    <option value="TBSM">TBSM</option>
                    <option value="TKRO">TKRO</option>
                    <option value="APAT">APAT</option>
                </select>
            </div>

            <div class="input-group">
                <label for="no_telepon">No_Telepon :</label>
                <input type="text" id="no_telepon" name="no_telepon" required>
            </div>

            <div class="input-group">
                <label for="username">Username :</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Password :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-batal" onclick="window.history.back()">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</main>

@endsection