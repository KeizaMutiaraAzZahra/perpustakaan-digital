@extends('anggota.layouts.main')

@section('title', 'Data Buku')

@section('content')
<div class="data-buku-anggota">
    <h2 class="section-title">DATA BUKU</h2>

    <div class="search-filter-container">
        <form action="{{ route('anggota.data-buku') }}" method="GET" class="w-100">
            <div class="search-wrapper mb-3">
                <div class="input-group">
                    <span class="search-icon"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" placeholder="Cari Buku" value="{{ request('keyword') }}">
                    <button type="submit" class="btn-cari">Cari</button>
                </div>
            </div>
            
            <div class="dropdown-filters">
                <select name="kategori" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Pelajaran" {{ request('kategori') == 'Pelajaran' ? 'selected' : '' }}>Pelajaran</option>
                    <option value="Novel" {{ request('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
                    <option value="Komik" {{ request('kategori') == 'Komik' ? 'selected' : '' }}>Komik</option>
                </select>

                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="kosong" {{ request('status') == 'kosong' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>

                @if(request('keyword') || request('kategori') || request('status'))
                    <a href="{{ route('anggota.data-buku') }}" class="btn btn-sm btn-secondary" style="margin-left: 10px;">Reset</a>
                @endif
            </div>
        </form>
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
    
            @php
                // Cek status pinjam user ini untuk buku ini
                $statusPinjam = \App\Models\Peminjaman::where('anggota_id', auth()->user()->anggota->id)
                                    ->where('buku_id', $item->id)
                                    ->whereIn('status', ['Diproses', 'Dipinjam'])
                                    ->first();
            @endphp

            <div class="action-wrapper" style="margin-top: 15px;">
                @if($statusPinjam)
                    <button class="btn-pinjam" disabled style="background-color: {{ $statusPinjam->status == 'Diproses' ? '#ffc107' : '#198754' }}; color: {{ $statusPinjam->status == 'Diproses' ? '#000' : '#fff' }}; opacity: 1; border: none; width: 100%; cursor: default;">
                        <i class="bi {{ $statusPinjam->status == 'Diproses' ? 'bi-clock' : 'bi-check-circle' }}"></i>
                        {{ $statusPinjam->status == 'Diproses' ? 'Menunggu Konfirmasi' : 'Sedang Dipinjam' }}
                    </button>
                @else
                    <a href="{{ route('anggota.detail-pinjam', $item->id) }}" class="btn-pinjam text-center d-block" style="width: 100%; text-decoration: none; line-height: 2.5;">
                        {{ $item->stok <= 0 ? 'Stok Habis' : 'Pinjam' }}
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-3">
    {{ $buku->links() }}
</div>
</div>
@endsection