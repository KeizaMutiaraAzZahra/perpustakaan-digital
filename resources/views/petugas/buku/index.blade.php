@extends('petugas.layouts.main')

@section('title', 'Data Buku')

@section('content')
<div class="data-buku-petugas">
    <h1 class="title">DATA BUKU</h1>

    {{-- 1. Bungkus semuanya dalam satu form agar data terkirim bersamaan --}}
    <form action="{{ route('petugas.buku.index') }}" method="GET">
        <div class="action-bar">
            <div class="search-wrapper" style="display: flex; align-items: center;">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" name="cari" placeholder="Cari Buku" value="{{ request('cari') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>
            </div>
            
            <a href="{{ route('petugas.buku.create') }}" class="btn-tambah">Tambah Buku</a>
        </div>

        <div class="filter-bar">
            <div class="filter-left">
                {{-- 2. Tambahkan onchange agar otomatis submit saat kategori dipilih --}}
                <select name="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Novel" {{ request('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
                    <option value="Komik" {{ request('kategori') == 'Komik' ? 'selected' : '' }}>Komik</option>
                    <option value="Pelajaran" {{ request('kategori') == 'Pelajaran' ? 'selected' : '' }}>Pelajaran</option>
                </select>
            </div>
            <div class="filter-right">
                {{-- 3. Tambahkan onchange agar otomatis submit saat pengurutan dipilih --}}
                <select name="urutkan" onchange="this.form.submit()">
                    <option value="terbaru" {{ request('urutkan') == 'terbaru' ? 'selected' : '' }}>Urutkan : Terbaru</option>
                    <option value="terlama" {{ request('urutkan') == 'terlama' ? 'selected' : '' }}>Urutkan : Terlama</option>
                </select>
            </div>
        </div>
    </form>

    <div class="book-list">
        @forelse($buku as $b)
        <div class="book-card">
            <div class="book-cover">
                @if($b->gambar)
                    <img src="{{ asset('storage/' . $b->gambar) }}" alt="Cover">
                @else
                    <img src="{{ asset('images/no-cover.jpg') }}" alt="No Cover">
                @endif
            </div>
            <div class="book-info">
                <h3 class="book-title">{{ $b->judul }}</h3>
                <p class="book-detail">id : {{ $b->id }}</p>
                <p class="book-detail">{{ $b->penulis }}</p>
                <p class="book-detail">{{ $b->tahun_terbit }} | {{ $b->kategori }}</p>
                <div class="stock-status">
                    <p>Stok : {{ $b->stok }}</p>
                    <span class="badge {{ $b->stok > 0 ? 'tersedia' : 'habis' }}">
                        {{ $b->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
            </div>
            <div class="book-actions">
                <a href="{{ route('petugas.buku.edit', $b->id) }}" class="btn-action edit">Edit</a>
                <form action="{{ route('petugas.buku.destroy', $b->id) }}" method="POST" style="display:inline;">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="btn-action hapus" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="alert alert-info">Data buku tidak ditemukan.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $buku->appends(request()->query())->links() }}
    </div>
</div>
@endsection