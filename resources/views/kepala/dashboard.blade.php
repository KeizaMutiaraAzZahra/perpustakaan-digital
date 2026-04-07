@extends('kepala.layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="dasboard-kepala">

    <div class="stats-container">
        <article class="stat-card">
            <img src="{{ asset('img/data-anggota.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Anggota</h2>
            <p class="teks-p">{{ $totalAnggota }}</p>
        </article>

        <article class="stat-card">
            <img src="{{ asset('img/data-petugas.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Petugas</h2>
            <p class="teks-p">{{ $totalPetugas }}</p>

        </article>

        <article class="stat-card">
            <img src="{{ asset('img/data-buku.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Buku</h2>
            <p class="teks-p">{{ $totalBuku }}</p>
        </article>

        <article class="stat-card">
            <img src="{{ asset('img/laporan-peminjaman.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Buku Sedang Dipinjam</h2>
            <p class="teks-p">{{ $bukuDipinjam }}</p>
        </article>

        <article class="stat-card">
            <img src="{{ asset('img/laporan-denda.svg') }}" class="icon-dashboard-kepala" />
            <h2 class="teks-dashboard-kepala">Total Denda</h2>
            <p class="teks-p">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </article>
    </div>

    <section class="rectangle-6">
        <h3>Aktivitas Terbaru</h3>
        <div class="activity-item">
            <i class="bi bi-clock-history"></i>
            @forelse ($aktivitas as $item)
                <p>
                    {{ $item->user->name ?? 'User' }} - 
                    Meminjam Buku {{ $item->buku->judul ?? '-' }}
                </p>
            @empty
                <p>Tidak ada aktivitas</p>
            @endforelse
        </div>
    </section>
</div>
@endsection