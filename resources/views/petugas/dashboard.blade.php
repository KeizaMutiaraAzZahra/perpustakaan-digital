@extends('petugas.layouts.main')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="dashboard-petugas">
    <h2 class="title">DASHBOARD</h2>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Anggota</span>
                <h3 class="stat-value">{{ $totalAnggota }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-book"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Buku</span>
                <h3 class="stat-value">{{ $totalBuku }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div class="stat-info">
                <span class="stat-label">Buku Dipinjam</span>
                <h3 class="stat-value">{{ $bukuDipinjam }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Denda</span>
                <h3 class="stat-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="recent-activity">
        <h3 class="section-subtitle">Aktivitas Terbaru</h3>
        <div class="activity-list">
            @forelse ($aktivitasTerbaru as $item)
                <div class="activity-item">
                    <i class="bi bi-arrow-right-square"></i>
                    <p>
                        {{-- Logika sederhana: jika denda > 0 maka tampilkan info denda, jika tidak tampilkan peminjaman --}}
                        @if($item->denda > 0)
                            Anggota Didenda : <strong>{{ $item->anggota->nama }}</strong> - Rp {{ number_format($item->denda, 0, ',', '.') }}
                        @else
                            Peminjaman : <strong>{{ $item->anggota->nama }}</strong> - {{ $item->created_at->format('d F Y') }}
                        @endif
                    </p>
                </div>
            @empty
                <div class="activity-item">
                    <p>Tidak ada aktivitas terbaru saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection