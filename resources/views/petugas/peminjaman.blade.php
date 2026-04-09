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
                    <td>{{ $p->tgl_pinjam ? \Carbon\Carbon::parse($p->tgl_pinjam)->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if($p->tgl_kembali)
                            <span class="{{ \Carbon\Carbon::parse($p->tgl_kembali)->isPast() && $p->status == 'dipinjam' ? 'text-danger' : '' }}">
                                {{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d-m-Y') }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($p->status == 'pending')
                            <span class="badge bg-pending">Pending</span>
                        @elseif($p->status == 'dipinjam')
                            <span class="badge bg-aktif">Dipinjam</span>
                        @elseif($p->status == 'terlambat')
                            <span class="badge bg-nonaktif">Terlambat</span>
                        @else
                            <span class="badge bg-selesai">Kembali</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($p->status == 'pending')
                            <form action="{{ route('petugas.peminjaman.konfirmasi', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="aksi" value="setuju" class="btn-aksi-konfirmasi">Konfirmasi</button>
                            </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection