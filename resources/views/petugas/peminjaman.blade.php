@extends('petugas.layouts.main')

@section('title', 'Data Peminjaman')

@section('content')
<div class="peminjaman-petugas">
    <div class="header-section">
        <h2 class="title">Data Peminjaman</h2>
        <hr class="line">
    </div>

    <div class="top-bar">
        <form action="{{ route('petugas.peminjaman') }}" method="GET" class="search-wrapper">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="cari" placeholder="Cari Peminjaman" value="{{ request('cari') }}">
            </div>
            <button type="submit" class="btn-cari">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="peminjaman-table">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tgl. Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Gunakan forelse untuk menangani kondisi data kosong --}}
                @forelse ($peminjaman as $index => $p)
                <tr>
                    {{-- Penomoran yang sinkron dengan pagination --}}
                    <td class="text-center">{{ $peminjaman->firstItem() + $index }}</td>
                    <td>{{ $p->anggota->nama }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $p->jatuh_tempo ? \Carbon\Carbon::parse($p->jatuh_tempo)->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $p->status == 'Diproses' ? 'bg-pending' : 'bg-aktif' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($p->status == 'Diproses')
                            <form action="{{ route('petugas.peminjaman.konfirmasi', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-aksi-konfirmasi">Konfirmasi</button>
                            </form>
                        @else
                            <span class="text-muted small">Telah Dikonfirmasi</span>
                        @endif
                    </td>
                </tr>
                @empty
                {{-- Tampilan jika data tidak ditemukan atau kosong --}}
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Tidak ada data peminjaman yang ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Navigasi Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $peminjaman->links() }} 
        </div>
    </div>
</div>
@endsection