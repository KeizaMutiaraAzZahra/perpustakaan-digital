@extends('kepala.layouts.main')

@section('title', 'Laporan Peminjaman')

@section('content')
<section class="laporan-peminjaman">
    <h2 class="title">Laporan Peminjaman</h2>

    <div class="table-card">
        <table class="main-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th class="text-right">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td class="text-right">
                        {{-- Logic class status berdasarkan isi text --}}
                        @php
                            $statusClass = '';
                            if($p->status == 'Dikembalikan' || $p->status == 'Kembali') $statusClass = 'status-kembali';
                            elseif($p->status == 'Masih Dipinjam' || $p->status == 'Dipinjam') $statusClass = 'status-pinjam';
                            elseif($p->status == 'Terlambat') $statusClass = 'status-lambat';
                        @endphp
                        <span class="status-label {{ $statusClass }}">{{ $p->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-data">Data tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('kepala.laporan.cetak', ['status' => 'Peminjaman']) }}" target="_blank" class="cetak-laporan">
        Cetak Laporan Peminjaman
    </a>
</section>
@endsection