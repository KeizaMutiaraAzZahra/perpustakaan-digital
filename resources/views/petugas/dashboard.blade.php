@extends('petugas.layouts.main')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="dashboard-petugas">
    <h1 class="page-title">DASHBOARD</h1>

    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Anggota</h3>
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-card">
            <h3>Total Buku</h3>
            <i class="bi bi-book"></i>
        </div>
        <div class="stat-card">
            <h3>Buku Dipinjam</h3>
            <i class="bi bi-book-half"></i>
        </div>
        <div class="stat-card">
            <h3>Total Denda</h3>
            <i class="bi bi-cash-stack"></i>
        </div>
    </div>

    <div class="activity-section">
        <h2 class="activity-title">Aktivitas Terbaru</h2>
        <div class="activity-table">
            <div class="activity-item">
                <i class="bi bi-arrow-right-circle"></i>
                <span>Peminjaman : Keiza Mutiara - 2 Februari 2026</span>
            </div>
            <div class="activity-item">
                <i class="bi bi-arrow-left-circle"></i>
                <span>Pengembalian : Zara - 16 Februari 2026</span>
            </div>
            <div class="activity-item">
                <i class="bi bi-exclamation-circle"></i>
                <span>Anggota Didenda : Intan - Rp 15.000</span>
            </div>
        </div>
    </div>
</div>
@endsection