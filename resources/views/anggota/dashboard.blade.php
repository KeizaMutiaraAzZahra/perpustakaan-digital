@extends('anggota.layouts.main')

@section('title', 'Data Peminjaman')

@section('content')
<div class="dashboard-anggota">
    <h2 class="title">DASHBOARD</h2>

    <div class="welcome-banner">
    <div class="user-profile-section">
        <h3 class="user-greeting">Selamat Datang, {{ auth()->user()->name }}.</h3>
        
        <div class="user-details-grid">
            <div class="detail-item">
                <strong>ID:</strong> {{ auth()->user()->id }}
            </div>
            
            <div class="detail-item">
                <strong>Peminjaman Aktif:</strong> {{ $peminjamanAktif }}
            </div>
            
            <div class="detail-item">
                <strong>Status:</strong> 
                <span class="status-badge">{{ ucfirst(auth()->user()->status) }}</span>
            </div>
            
            <div class="detail-item">
                <strong>Total Denda:</strong> 
                Rp {{ number_format($totalDenda, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

    <div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-book"></i></div>
        <div class="stat-info">
            <span class="stat-label">Buku Dipinjam</span>
            <span class="stat-value">{{ $peminjamanAktif }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-box-arrow-in-right"></i></div>
        <div class="stat-info">
            <span class="stat-label">Sudah Dikembalikan</span>
            <span class="stat-value">{{ $totalKembali ?? 0 }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
        <div class="stat-info">
            <span class="stat-label">Buku Jatuh Tempo</span>
            <span class="stat-value">{{ $totalJatuhTempo ?? 0 }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
        <div class="stat-info">
            <span class="stat-label">Total Denda</span>
            <span class="stat-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

    <div class="action-footer">
        <a href="{{ route('anggota.data-buku') }}" class="btn-cari-buku">
            <i class="bi bi-plus-circle"></i> Cari Buku
        </a>
    </div>
</div>

@endsection