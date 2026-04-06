@extends('petugas.layouts.main')

@section('title', 'Data Peminjaman')

@section('content')
<div class="peminjaman-petugas">
    <h1 class="title">Data Peminjaman</h1>

    <div class="action-bar">
        <form action="{{ route('petugas.peminjaman.index') }}" method="GET" class="search-form">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari Anggota / Buku">
                <button type="submit" class="btn-cari">Cari</button>
            </div>
        </form>
        
        <a href="{{ route('petugas.peminjaman.create') }}" class="btn-input">+ Input Pinjam</a>
    </div>

    <div class="table-container">
        <table class="peminjaman-table">
            <thead>
                <tr>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Jatuh Tempo</th>
                    <th>Status / Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td>{{ $item->anggota->nama }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}</td>
                    <td>
                        @if($item->status == 'Dipinjam')
                            <span class="badge dipinjam">Dipinjam</span>
                        @elseif($item->status == 'Terlambat')
                            <span class="badge terlambat">Terlambat</span>
                        @else
                            <span class="badge kembali">Kembali</span>
                        @endif
                        
                        <a href="{{ route('petugas.peminjaman.show', $item->id) }}" class="btn-detail-icon">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">Data peminjaman tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection