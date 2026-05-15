@extends('anggota.layouts.main')

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

        <form action="{{ route('anggota.profile.update') }}" method="POST">
            @csrf
            
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
                <label>No Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $user->anggota->no_telepon ?? '') }}">
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <select name="kelas" class="form-select">
                    @php $kls = old('kelas', $user->anggota->kelas ?? ''); @endphp
                    <option value="" disabled {{ $kls == '' ? 'selected' : '' }}>Pilih Kelas</option>
                    <option value="X" {{ $kls == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ $kls == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ $kls == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <select name="jurusan" class="form-select">
                    @php $jrs = old('jurusan', $user->anggota->jurusan ?? ''); @endphp
                    <option value="" disabled {{ $jrs == '' ? 'selected' : '' }}>Pilih Jurusan</option>
                    <option value="PPLG" {{ $jrs == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                    <option value="APAT" {{ $jrs == 'APAT' ? 'selected' : '' }}>APAT</option>
                    <option value="AKL" {{ $jrs == 'AKL' ? 'selected' : '' }}>AKL</option>
                    <option value="TBSM" {{ $jrs == 'TBSM' ? 'selected' : '' }}>TBSM</option>
                    <option value="TKRO" {{ $jrs == 'TKRO' ? 'selected' : '' }}>TKRO</option>
                </select>
            </div>

            <div class="button-group">
                <a href="{{ route('anggota.profile.index') }}" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection