@extends('petugas.layouts.main')

@section('title', 'Profil Saya')

@section('content')
<div class="profil-anggota">
    <h2 class="section-title">Profil Saya</h2>

    <div class="profile-card">
        <div class="profile-left">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <h3 class="user-name">{{ $user->name }}</h3>
            <span class="role-badge">{{ ucfirst($user->role) }}</span>
        </div>

        <div class="profile-right">
            <h4 class="info-title">Informasi Akun</h4>
            
            <div class="info-item">
                <label>Nama Lengkap</label>
                <p>{{ $user->name }}</p>
            </div>

            <div class="info-item">
                <label>Username</label>
                <p>{{ $user->username }}</p>
            </div>

            {{-- Bagian Jenis Kelamin --}}
            <div class="info-item mb-3">
                <label class="text-muted d-block small uppercase fw-bold">Jenis Kelamin</label>
                <p class="mb-0 text-dark">
                    @php
                        $jk = $user->petugas->jenis_kelamin ?? '-';
                    @endphp
                    {{ $jk == 'L' || $jk == 'Laki-laki' ? 'Laki-laki' : ($jk == 'P' || $jk == 'Perempuan' ? 'Perempuan' : '-') }}
                </p>
            </div>

            {{-- Bagian No Telepon --}}
            <div class="info-item mb-3">
                <label class="text-muted d-block small uppercase fw-bold">No Telepon</label>
                <p class="mb-0 text-dark">{{ $user->petugas->no_telepon ?? '-' }}</p>
            </div>

            {{-- Bagian Alamat --}}
            <div class="info-item mb-3">
                <label class="text-muted d-block small uppercase fw-bold">Alamat</label>
                <p class="mb-0 text-dark">{{ $user->petugas->alamat ?? '-' }}</p>
            </div>

            <div class="info-item">
                <label>Status Akun</label>
                <p class="status-active"><i class="bi bi-check-circle-fill"></i> Aktif</p>
            </div>
            
            <hr class="divider">
            <div class="profile-actions">
                <a href="{{ route('petugas.profile.edit') }}">
                    <button class="btn-edit">Edit Profil</button>
                </a>

            </div>
        </div>
    </div>
</div>
@endsection