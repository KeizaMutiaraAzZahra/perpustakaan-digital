@extends('petugas.layouts.main')

@section('title', 'Data Denda')

@section('content')
<div class="peminjaman-petugas">
    <div class="header-section">
        <h2 class="title">Data Denda Anggota</h2>
        <hr class="line">
    </div>

    <div class="top-bar">
        <form action="{{ route('petugas.denda') }}" method="GET" class="search-wrapper">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="cari" placeholder="Cari Nama Anggota" value="{{ request('cari') }}">
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
                    <th class="text-center">Total Denda</th>
                    <th class="text-center">Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($denda as $index => $d)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>**{{ $d->anggota->nama }}**</td>
                    <td>{{ $d->buku->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->jatuh_tempo)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal_kembali)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        <span style="color: #dc3545; font-weight: bold;">
                            Rp {{ number_format($d->denda, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge" style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
                            Menunggu Pembayaran
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada anggota yang memiliki denda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection