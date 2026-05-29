@extends('kepala.layouts.main')

@section('title', 'Laporan Pengembalian')

@section('content')
<section class="laporan-pengembalian">
    <h2 class="page-title">Laporan Denda</h2>

    <div class="table-card">
        <table class="main-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Kembali</th>
                    <th class="text-right">Total Denda</th>
                    <th class="text-right">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($denda as $index => $item)
                    <tr>
                        <td class="text-center">
                            {{ ($denda->currentPage() - 1) * $denda->perPage() + $loop->iteration }}
                        </td>
                        {{-- Samakan persis dengan laporan pengembalian --}}
                        <td>{{ $item->anggota->nama ?? '-' }}</td>
                        <td>{{ $item->buku->judul ?? '-' }}</td>
                        <td class="text-center">
                            {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="text-center fw-bold text-danger">
                            Rp {{ number_format($item->denda, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            {{-- Logika status yang lebih aman --}}
                            @if($item->status_denda == 'lunas')
                                <span class="badge bg-success text-white px-3 py-2 rounded-pill">Lunas</span>
                            @else
                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data denda (Semua tepat waktu).</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('kepala.laporan.cetak', ['status' => 'Denda']) }}" target="_blank" class="cetak-laporan">
        Cetak Laporan Denda
    </a>

@endsection