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

            <div class="info-item">
                <label>Email</label>
                <p>{{ $user->email ?? '-' }}</p>
            </div>

            <div class="info-item">
                <label>Status Akun</label>
                <p class="status-active">
                    <i class="bi bi-check-circle-fill"></i> 
                    {{ ucfirst($user->status) }}
                </p>
            </div>
            
            <hr class="divider">
            <div class="profile-actions">
                <a href="{{ route('kepala.profile.edit') }}">
                    <button class="btn-edit">Edit Profil</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection