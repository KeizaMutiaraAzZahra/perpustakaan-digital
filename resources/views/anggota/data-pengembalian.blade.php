@extends('anggota.layouts.main')

@section('title', 'Data Pengembalian')

@section('content')

<div class="pengembalian-anggota">
    <h2 class="main-title">Pengembalian</h2>

    <div class="search-section">
        <form action="{{ route('anggota.data-pengembalian') }}" method="GET" class="search-wrapper">
            <div class="search-input-group">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="keyword" class="search-control" placeholder="Riwayat Pengembalian" value="{{ request('keyword') }}">
                <button type="submit" class="btn-cari">Cari</button>
            </div>
        </form>
    </div>

    <div class="content-card">
        <div class="content-header">
            <h4 class="content-subtitle">Pengembalian</h4>
        </div>
        
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalian as $item)
                    <tr>
                        <td>{{ $item->buku->judul }}</td>
                        {{-- Gunakan optional atau ternary agar tidak error jika field null --}}
                        <td>{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : 'Diproses...' }}</td>
                        <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($item->status == 'Menunggu Konfirmasi')
                                {{-- Status saat anggota sudah klik kembalikan tapi petugas belum konfirmasi --}}
                                <span class="status-badge" style="background-color: #f1c40f; color: #000; padding: 5px 10px; border-radius: 5px; display: inline-block; font-size: 12px;">
                                    <i class="bi bi-clock"></i> Menunggu Petugas
                                </span>
                            @elseif($item->status == 'Terlambat')
                                <span class="status-badge" style="background-color: #e74c3c; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block;">
                                    Terlambat
                                </span>
                                <a href="{{ route('anggota.data-denda') }}" 
                                style="display: block; margin-top: 5px; color: #e74c3c; font-size: 11px; text-decoration: underline; font-weight: bold;">
                                    Bayar Denda <i class="bi bi-arrow-right"></i>
                                </a>
                            @else
                                <span class="status-badge" style="background-color: #2ecc71; color: white; padding: 5px 10px; border-radius: 5px;">
                                    Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada riwayat pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="content-footer">
            <p>Menampilkan {{ $pengembalian->count() }} dari pengembalian anda</p>
        </div>
    </div>
</div>

@endsection