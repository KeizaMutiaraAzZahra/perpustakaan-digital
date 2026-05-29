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
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pengembalian as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ $p->jatuh_tempo ? \Carbon\Carbon::parse($p->jatuh_tempo)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d-m-Y') : '-' }}</td>
                    
                    <td class="text-center">
                        @if($p->denda > 0)
                            <span style="color:red; font-weight:bold;">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span style="color:green;">-</span>
                        @endif
                    </td>

                    {{-- STATUS: Paksa Muncul --}}
                    <td class="text-center">
                        @php $st = strtolower(trim($p->status)); @endphp
                        @if($st == 'kembali' || $st == 'selesai')
                            <span class="badge bg-success" style="background-color: #28a745; color: white; padding: 5px 10px;">Kembali</span>
                        @elseif($st == 'terlambat')
                            <span class="badge bg-danger" style="background-color: #dc3545; color: white; padding: 5px 10px;">Terlambat</span>
                        @else
                            <span class="badge bg-secondary" style="background-color: #6c757d; color: white; padding: 5px 10px;">{{ $p->status ?? 'Selesai' }}</span>
                        @endif
                    </td>

                    {{-- AKSI: Cuma muncul kalau butuh konfirmasi --}}
                    <td class="text-center">
                        @if(strtolower(trim($p->status)) == 'menunggu konfirmasi')
                            <form action="{{ route('petugas.konfirmasi-pengembalian', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-warning btn-sm">Konfirmasi</button>
                            </form>
                        @else
                            <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data pengembalian.</td>
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