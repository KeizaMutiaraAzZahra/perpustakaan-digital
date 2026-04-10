@extends('anggota.layouts.main')

@section('title', 'Data Peminjaman')

@section('content')
<div class="dashboard-anggota">
    <h2 class="main-title">DASHBOARD</h2>

    <div class="welcome-banner">
        <div class="user-profile-section">
            <h3 class="user-greeting">Selamat Datang, {{ auth()->user()->name }}.</h3>
            <div class="user-details-grid">
                <div class="detail-item">ID: {{ auth()->user()->id }}</div>
                <div class="detail-item">Peminjaman Aktif: 2</div>
                <div class="detail-item">Status: <span class="status-badge">Aktif</span></div>
                <div class="detail-item">Total Denda: 10.000</div>
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-book"></i>
            </div>
            <span class="stat-label">Buku Dipinjam</span>
            <h4 style="margin-top: 10px;">{{ $peminjamanAktif }}</h4>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-box-arrow-up-right"></i>
            </div>
            <span class="stat-label">Sudah Dikembalikan</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-journal-x"></i>
            </div>
            <span class="stat-label">Buku Jatuh Tempo</span>
            <h4 style="margin-top: 10px;">{{ $peminjamanAktif }}</h4>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-cash-stack"></i>
            </div>
            <span class="stat-label">Denda Belum Dibayar</span>
            <h4 style="margin-top: 10px;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h4>
        </div>
    </div>

    <div class="action-footer">
        <a href="{{ route('anggota.data-buku') }}" class="btn-cari-buku">
            <i class="bi bi-plus-circle"></i> Cari Buku
        </a>
    </div>
</div>

@endsection