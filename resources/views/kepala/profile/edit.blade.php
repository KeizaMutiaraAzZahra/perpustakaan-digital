@extends('kepala.layouts.main')

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

        <form action="{{ route('kepala.profile.update') }}" method="POST">
            @csrf
            @method('PUT') {{-- Biasanya update menggunakan method PUT/PATCH --}}
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label>Password Baru (Kosongkan jika tidak ingin ganti)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="button-group">
                <a href="{{ route('kepala.profile.index') }}" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection