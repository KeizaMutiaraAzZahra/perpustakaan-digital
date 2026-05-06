@extends('petugas.layouts.main')

@section('title', 'Data Pengembalian')

@section('content')
<div class="peminjaman-petugas">
    <div class="header-section">
        <h2 class="title">Data Pengembalian</h2>
        <hr class="line">
    </div>

    <div class="top-bar">
        <form action="{{ route('petugas.pengembalian') }}" method="GET" class="search-wrapper">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="cari" placeholder="Cari Pengembalian" value="{{ request('cari') }}">
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
                    <th>Jatuh Tempo</th>
                    <th>Tgl. Kembali</th>
                    <th class="text-center">Denda</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->jatuh_tempo)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        @if($p->denda > 0)
                            <span style="color: #dc3545; font-weight: bold;">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span style="color: #28a745;">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-selesai" style="background-color: #28a745;">Selesai</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data pengembalian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $pengembalian->links() }} 
        </div>
    </div>
</div>
@endsection