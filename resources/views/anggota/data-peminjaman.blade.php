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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamanAktif as $aktif)
                    <tr>
                        <td>{{ $aktif->buku->judul }}</td>
                        <td>{{ $aktif->tanggal_pinjam ? ($aktif->tanggal_pinjam)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $aktif->jatuh_tempo ? ($aktif->jatuh_tempo)->format('d-m-Y') : '-' }}</td>
                        <td class="text-center">
                            {{ $aktif->status ?? 'Data Kosong' }}
                        </td>
                            <td>
                                {{-- Tombol muncul jika statusnya Dipinjam ATAU Terlambat --}}
                                @if($aktif->status == 'Dipinjam' || (now()->startOfDay()->gt(\Carbon\Carbon::parse($aktif->jatuh_tempo)->startOfDay())))
                                    <a href="{{ route('anggota.form-pengembalian', $aktif->id) }}" class="btn btn-success btn-sm">
                                        Kembalikan
                                    </a>
                                @elseif($aktif->status == 'Diproses')
                                    <span class="text-muted small">Menunggu Konfirmasi</span>
                                @else
                                    -
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
                    @forelse($riwayatPeminjaman as $riwayat)
                    <tr>
                        <td>{{ $riwayat->buku->judul }}</td>
                        {{-- Tanggal Pinjam --}}
                        <td>{{ $riwayat->tanggal_pinjam ? $riwayat->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                        {{-- Tanggal Kembali --}}
                        <td>{{ $riwayat->tanggal_kembali ? $riwayat->tanggal_kembali->format('d-m-Y') : '-' }}</td>
                        {{-- Kolom Denda --}}
                        <td>
                            @if($riwayat->denda > 0)
                                <span class="text-danger">Rp {{ number_format($riwayat->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-success">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            @php
                                // Pastikan variabelnya $riwayat, bukan $item
                                $jatuhTempo = \Carbon\Carbon::parse($riwayat->jatuh_tempo);
                                $terlambat = now()->startOfDay()->gt($jatuhTempo->startOfDay());
                            @endphp

                            @if($terlambat && $riwayat->status == 'Dipinjam')
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                {{-- Warna biru untuk Diproses/Dipinjam, Hijau untuk Kembali --}}
                                <span class="badge {{ $riwayat->status == 'Kembali' ? 'bg-success' : 'bg-primary' }}">
                                    {{ $riwayat->status }}
                                </span>
                            @endif
                        </td>
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