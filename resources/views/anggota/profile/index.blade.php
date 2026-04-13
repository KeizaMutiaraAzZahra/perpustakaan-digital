@extends('anggota.layouts.main')

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

            <div class="info-item">
                <label>Email</label>
                <p>{{ $user->email }}</p>
            </div>
            
            <div class="info-item mb-3">
                <label class="text-muted d-block small uppercase fw-bold">Kelas</label>
                {{-- Ambil dari tabel anggota via relasi --}}
                <p class="mb-0 text-dark">{{ $user->anggota->kelas ?? '-' }}</p>
            </div>

            <div class="info-item mb-3">
                <label class="text-muted d-block small uppercase fw-bold">Jurusan</label>
                <p class="mb-0 text-dark">{{ $user->anggota->jurusan ?? '-' }}</p>
            </div>

            <div class="info-item mb-3">
                <label class="text-muted d-block small uppercase fw-bold">No Telepon</label>
                <p class="mb-0 text-dark">{{ $user->anggota->no_telepon ?? '-' }}</p>
            </div>

            <div class="info-item">
                <label>Status Akun</label>
                <p class="status-active"><i class="bi bi-check-circle-fill"></i> Aktif</p>
            </div>
            
            <hr class="divider">
            <div class="profile-actions">
                <a href="{{ route('anggota.profile.edit') }}">
                    <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit Profil</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection