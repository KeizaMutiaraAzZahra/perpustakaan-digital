@extends('anggota.layouts.main')

@section('title', 'Data Peminjaman')

@section('content')

<div class="peminjaman-anggota">
    <h2 class="main-title">Peminjaman</h2>

    <div class="section-card">
        <h4 class="section-subtitle">Peminjaman Aktif</h4>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($peminjamanAktif as $aktif)
                <tr>
                    <td>{{ $aktif->buku->judul }}</td>
                    {{-- Pakai format tanggal yang aman --}}
                    <td>{{ $aktif->tanggal_pinjam ? $aktif->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                    <td>{{ $aktif->jatuh_tempo ? $aktif->jatuh_tempo->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">
                        {{-- CEK STATUS DISINI (Harus 'Diproses' sesuai database) --}}
                        @if($aktif->status == 'Diproses')
                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                        @elseif($aktif->status == 'Dipinjam')
                            <span class="badge bg-primary">Sedang Dipinjam</span>
                        @elseif($aktif->status == 'Terlambat')
                            <span class="badge bg-danger">Terlambat</span>
                        @else
                            <span class="badge bg-secondary">{{ $aktif->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada peminjaman aktif</td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>
        <p class="table-footer-info">Menampilkan {{ $peminjamanAktif->count() }} dari peminjaman aktif</p>
    </div>

    <div class="section-card mt-4">
        <h4 class="section-subtitle">Riwayat Peminjaman</h4>
        
        <div class="search-bar">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Riwayat Peminjaman">
                <button class="btn-primary">Cari</button>
            </div>
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
                @forelse($riwayatPeminjaman as $riwayat) {{-- UBAH INI: Pastikan pakai $riwayatPeminjaman --}}
                <tr>
                    <td>{{ $riwayat->buku->judul }}</td>
                    <td>{{ ($riwayat->tanggal_pinjam)->format('d-m-Y') }}</td>
                    <td>{{ ($riwayat->tanggal_kembali)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($riwayat->denda, 0, ',', '.') }}</td>
                    <td><span class="badge badge-success">Selesai</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada riwayat peminjaman</td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

@endsection