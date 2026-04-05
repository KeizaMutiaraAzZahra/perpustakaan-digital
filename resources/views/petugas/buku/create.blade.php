@extends('petugas.layouts.main')

@section('title', 'Tambah Buku')

@section('content')
<div class="tambah-buku-petugas">
    <div class="card-form">
        <div class="header-form">
            <h2 class="title">Tambah Buku</h2>
        </div>

        <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Judul Buku :</label>
                <input type="text" name="judul" class="input-field" required>
            </div>

            <div class="form-group">
                <label>Penulis :</label>
                <input type="text" name="penulis" class="input-field" required>
            </div>

            <div class="form-group">
                <label>Tahun Terbit :</label>
                <input type="number" name="tahun_terbit" class="input-field" required>
            </div>

        <div class="form-group">
            <label>Kategori :</label>
            <select name="kategori" class="input-field" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="Pelajaran">Pelajaran</option>
                <option value="Novel">Novel</option>
                <option value="Komik">Komik</option>
            </select>
        </div>

            <div class="form-group">
                <label>Stok :</label>
                <input type="number" name="stok" class="input-field" required>
            </div>

            <div class="form-group">
                <label>Upload Gambar :</label>
                <div class="file-input-wrapper">
                    <input type="file" name="gambar" id="cover" class="input-file">
                </div>
            </div>

            <div class="button-group">
                <a href="{{ route('petugas.buku.index') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection