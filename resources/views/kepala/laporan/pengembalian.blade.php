@extends('kepala.layouts.main')

@section('title', 'Laporan Pengembalian')

@section('content')
<section class="laporan-pengembalian">
    <h2 class="page-title">Laporan Pengembalian</h2>

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
        <a href="{{ route('kepala.laporan.cetak', ['status' => 'Kembali']) }}" class="btn btn-success">Cetak Pengembalian</a>
    </div>
</section>
@endsection