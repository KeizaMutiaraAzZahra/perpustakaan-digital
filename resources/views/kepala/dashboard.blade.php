@extends('kepala.layouts.main')

@section('title', 'Dashboard Kepala')

@section('content')
<div class="dashboard-kepala">
    <h2 class="title">DASHBOARD</h2>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('img/data-anggota.svg') }}" style="width: 45px;"></div>
            <div class="stat-info">
                <span class="stat-label">Total Anggota</span>
                <h3 class="stat-value">{{ $totalAnggota }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('img/data-petugas.svg') }}" style="width: 45px;"></div>
            <div class="stat-info">
                <span class="stat-label">Total Petugas</span>
                <h3 class="stat-value">{{ $totalPetugas }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('img/data-buku.svg') }}" style="width: 45px;"></div>
            <div class="stat-info">
                <span class="stat-label">Total Buku</span>
                <h3 class="stat-value">{{ $totalBuku }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('img/laporan-peminjaman.svg') }}" style="width: 45px;"></div>
            <div class="stat-info">
                <span class="stat-label">Buku Dipinjam</span>
                <h3 class="stat-value">{{ $bukuDipinjam }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><img src="{{ asset('img/laporan-denda.svg') }}" style="width: 45px;"></div>
            <div class="stat-info">
                <span class="stat-label">Total Denda</span>
                <h3 class="stat-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="activity-list">
        @forelse ($aktivitas as $item)
            <div class="activity-item">
                <i class="bi bi-arrow-right-square"></i>
                <p>
                    <strong>{{ $item->user->name ?? 'Pengguna' }}</strong> - 
                    Meminjam Buku <strong>{{ $item->buku->judul ?? '-' }}</strong>
                </p>
            </div>
        @empty
            <div class="activity-item">
                <p>Tidak ada aktivitas terbaru saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection