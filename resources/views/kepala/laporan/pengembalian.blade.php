@extends('kepala.layouts.main')

@section('title', 'Laporan Pengembalian')

@section('content')
<section class="laporan-pengembalian">
    <h2 class="page-title">Laporan Pengembalian</h2>

    <div class="top-bar">
        <form action="{{ route('kepala.laporan.pengembalian') }}" method="GET" class="search-wrapper">
            
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Cari" value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn-cari">Cari</button>

            <div class="search-box">
                <input type="date" name="start_date" value="{{ request('start_date') }}">
                <input type="date" name="end_date" value="{{ request('end_date') }}">
            </div>

            <button type="submit" class="btn-cari">Filter</button>

            <input type="hidden" name="status" value="Pengembalian">
        </form>
    </div>

    <div class="table-card">
        <table class="main-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Kembali</th>
                    <th class="text-right">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d/m/Y') }}</td>
                    <td class="text-right">
                        <span class="denda-value {{ $p->denda > 0 ? 'has-denda' : 'no-denda' }}">
                            Rp {{ number_format($p->denda, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-data">Belum ada data pengembalian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
       <a href="{{ route('kepala.laporan.cetak', request()->query()) }}" target="_blank" class="cetak-laporan">
            Cetak Laporan Pengembalian
        </a>
</section>
@endsection