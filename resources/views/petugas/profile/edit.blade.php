@extends('petugas.layouts.main')

@section('title', 'Edit Profil')

@section('content')
<div class="edit-profil">
    <div class="modal-content">
        <h4 class="title">Edit Profil Saya</h4>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.profile.update') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
            </div>
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $user->petugas->no_telepon ?? '') }}">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    @php 
                        $jk = old('jenis_kelamin', $user->petugas->jenis_kelamin ?? ''); 
                    @endphp
                    <option value="L" {{ $jk == 'L' || $jk == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $jk == 'P' || $jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group align-items-start">
                <label class="mt-2">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $user->petugas->alamat ?? '') }}</textarea>
            </div>

            <div class="button-group">
                <a href="{{ route('petugas.profile.index') }}" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection