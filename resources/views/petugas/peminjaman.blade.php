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
                @foreach ($peminjaman as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $p->jatuh_tempo?->format('d-m-Y') ?? '-' }}</td>
                    
                   <td class="text-center">
                        @if($aktif->status == 'Diproses')
                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                        @elseif($aktif->status == 'Dipinjam')
                            <span class="badge bg-primary">Sedang Dipinjam</span>
                        @else
                            <span class="badge bg-secondary">{{ $aktif->status }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($p->status == 'Diproses')
                            <form action="{{ route('petugas.peminjaman.konfirmasi', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-aksi-konfirmasi">Konfirmasi</button>
                            </form>
                        @else
                            <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection