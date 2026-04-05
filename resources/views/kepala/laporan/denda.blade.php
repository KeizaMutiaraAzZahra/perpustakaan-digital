@extends('kepala.layouts.main')

@section('title', 'Laporan Denda')

@section('content')
<div class="laporan-denda-kepala">
    <div class="header-section">
        <h1 class="title">Laporan Denda</h1>
        <hr class="line">
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Anggota</th>
                    <th>Judul buku</th>
                    <th class="text-center">Hari Terlambat</th>
                    <th>Total Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($denda as $index => $d)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $d->anggota->nama }}</td>
                    <td>{{ $d->buku->judul }}</td>
                    <td class="text-center">{{ $d->hari_terlambat }} Hari</td>
                    <td>Rp. {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada laporan denda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection