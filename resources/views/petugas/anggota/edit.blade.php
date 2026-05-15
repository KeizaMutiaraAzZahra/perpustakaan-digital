@extends('petugas.layouts.main')

@section('title', 'Edit Anggota')

@section('content')
<main class="tambah-anggota-petugas">
    <div class="form-container">
        <div class="form-header">
            <h2>Edit Anggota</h2>
        </div>

        {{-- Route arahin ke update, kirim ID-nya, dan tambahin @method('PUT') --}}
        <form action="{{ route('petugas.anggota.update', $anggota->id) }}" method="POST" class="form-body">
            @csrf
            @method('PUT')
            
            <div class="input-group">
                <label for="nama">Nama :</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $anggota->nama) }}" required>
            </div>

            <div class="input-group">
                <label for="kelas">Kelas :</label>
                <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $anggota->kelas) }}" required>
            </div>

            <div class="input-group">
                <label for="jurusan">Jurusan :</label>
                <select id="jurusan" name="jurusan">
                    @foreach(['PPLG', 'AKL', 'TBSM', 'TKRO', 'APAT'] as $j)
                        <option value="{{ $j }}" {{ $anggota->jurusan == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <label for="no_telepon">No_Telepon :</label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}" required>
            </div>

            <div class="input-group">
                <label for="username">Username :</label>
                {{-- Username diambil dari relasi user --}}
                <input type="text" id="username" name="username" value="{{ old('username', $anggota->user->username) }}" required>
            </div>

            <div class="input-group">
                <label for="password">Password :</label>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin ganti password">
                <small style="color: gray;">*Kosongkan jika tidak ingin mengganti password</small>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Aktif" {{ $anggota->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ $anggota->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-batal" onclick="window.history.back()">Batal</button>
                <button type="submit" class="btn-simpan">Update Data</button>
            </div>
        </form>
    </div>
</main>
@endsection