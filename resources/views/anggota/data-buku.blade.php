@extends('anggota.layouts.main')

@section('title', 'Data Buku')

@section('content')
<div class="data-buku-anggota">
    <h2 class="section-title">DATA BUKU</h2>

    <div class="search-filter-container">
        <form action="{{ route('anggota.buku.search') }}" method="GET" class="search-wrapper">
            <div class="input-group">
                <span class="search-icon"><i class="bi bi-search"></i></span>
                <input type="text" name="keyword" placeholder="Cari Buku" value="{{ request('keyword') }}">
                <button type="submit" class="btn-cari">Cari</button>
            </div>
        </form>
        
        <div class="dropdown-filters">
            <select name="kategori" class="filter-select">
                <option value="">Semua Kategori</option>
                <option value="Novel">Novel</option>
                <option value="Pelajaran">Buku Paket</option>
            </select>
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="tersedia">Tersedia</option>
                <option value="kosong">Tidak Tersedia</option>
            </select>
        </div>
    </div>

    <div class="book-grid">
        @foreach($buku as $item)
        <div class="book-card">
            <div class="book-info-wrapper">
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="book-cover">
                <div class="book-details">
                    <h4 class="book-title">{{ $item->judul }}</h4>
                    <p class="book-meta">Id : {{ $item->id }}</p>
                    <p class="book-meta">{{ $item->penulis }}</p>
                    <p class="book-meta">{{ $item->tahun_terbit }} | {{ $item->kategori }}</p>
                    
                    <div class="status-stock-wrapper">
                        @if($item->stok > 0)
                            <span class="badge status-tersedia">Tersedia</span>
                        @else
                            <span class="badge status-kosong">Tidak Tersedia</span>
                        @endif
                        <span class="stock-count">{{ $item->stok }}</span>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('anggota.peminjaman.store') }}" method="POST">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $item->id }}">
                <button type="submit" class="btn-pinjam" {{ $item->stok <= 0 ? 'disabled' : '' }}>Pinjam</button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="pagination-container">
        <div class="pagination-wrapper">
            <a href="#" class="page-nav"><i class="bi bi-chevron-left"></i></a>
            <a href="#" class="page-number active">1</a>
            <a href="#" class="page-number">2</a>
            <a href="#" class="page-number">3</a>
            <a href="#" class="page-number">4</a>
            <a href="#" class="page-nav"><i class="bi bi-chevron-right"></i></a>
        </div>
    </div>
</div>

@endsection