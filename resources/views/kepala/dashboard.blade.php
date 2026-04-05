@extends('kepala.layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="dasboard-kepala">

    <div class="stats-container">
        <article class="stat-card">
            <img src="{{ asset('img/data-anggota.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Anggota</h2>
        </article>

        <article class="stat-card">
            <img src="{{ asset('img/data-petugas.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Petugas</h2>
        </article>

        <article class="stat-card">
            <img src="{{ asset('img/data-buku.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Buku</h2>
        </article>

        <article class="stat-card">
            <img src="{{ asset('img/laporan-peminjaman.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Buku Sedang Dipinjam</h2>
        </article>

        <article class="stat-card">
            <img src="{{ asset('img/laporan-denda.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Denda</h2>
        </article>
    </div>

    <section class="rectangle-6">
        <h3>Aktivitas Terbaru</h3>
        <div class="activity-item">
            <i class="bi bi-clock-history"></i>
            <p>Keiza - Meminjam Buku Laskar Pelangi</p>
        </div>
    </section>
</div>
@endsection