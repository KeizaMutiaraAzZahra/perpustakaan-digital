@extends('petugas.layouts.main')

@section('title', 'Edit Buku')

@section('content')
<div class="tambah-buku-petugas">
    <div class="card-form">
        <div class="header-form">
            <h2 class="title">Edit Buku</h2>
        </div>

        <form action="{{ route('petugas.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Judul Buku :</label>
                <input 
                    type="text" 
                    name="judul" 
                    class="input-field"
                    value="{{ old('judul', $buku->judul) }}" 
                    required>
            </div>

            <div class="form-group">
                <label>Penulis :</label>
                <input 
                    type="text" 
                    name="penulis" 
                    class="input-field"
                    value="{{ old('penulis', $buku->penulis) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Tahun Terbit :</label>
                <input 
                    type="number" 
                    name="tahun_terbit" 
                    class="input-field"
                    value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                    required>
            </div>

            <div class="form-group">
                <label>Kategori :</label>
                <select name="kategori" class="input-field" required>
                    <option value="Pelajaran" {{ old('kategori', $buku->kategori) == 'Pelajaran' ? 'selected' : '' }}>Pelajaran</option>
                    <option value="Novel" {{ old('kategori', $buku->kategori) == 'Novel' ? 'selected' : '' }}>Novel</option>
                    <option value="Komik" {{ old('kategori', $buku->kategori) == 'Komik' ? 'selected' : '' }}>Komik</option>
                </select>
            </div>

            <div class="form-group">
                <label>Stok :</label>
                <input 
                    type="number" 
                    name="stok" 
                    class="input-field"
                    value="{{ old('stok', $buku->stok) }}" 
                    required>
            </div>

            <div class="form-group">
                <label>Upload Gambar :</label>

                {{-- Preview gambar lama --}}
                @if ($buku->gambar)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $buku->gambar) }}" width="100">
                    </div>
                @endif

                <div class="file-input-wrapper">
                    <input type="file" name="gambar" class="input-file">
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