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
                    @foreach($peminjamanAktif as $aktif)
                    <tr>
                        <td>{{ $aktif->buku->judul }}</td>
                        <td>{{ $aktif->tanggal_pinjam ?? '-' }}</td>
                        <td>{{ $aktif->jatuh_tempo ?? '-' }}</td>
                        
                        <td class="text-center">
                            @if($aktif->status == 'Terlambat')
                                <span class="badge badge-danger">Terlambat</span>
                            @else
                                <span class="badge badge-warning" style="background-color: #303f9f; color: white;">{{ $aktif->status }}</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('anggota.form-pengembalian', $aktif->id) }}" class="btn-kembalikan">
                                Kembalikan
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if($peminjamanAktif->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Belum ada peminjaman aktif</td>
                    </tr>
                    @endif
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
                    @if(count($riwayatPeminjaman) > 0)
                        @foreach($riwayatPeminjaman as $riwayat)
                            <tr>
                                <td>{{ $riwayat->buku->judul }}</td>
                                <td>{{ $riwayat->tanggal_pinjam ?? '-' }}</td>
                                <td>{{ $riwayat->tanggal_kembali ?? '-' }}</td>
                                <td>
                                    @if($riwayat->denda > 0)
                                        <span style="color: red; font-weight: bold;">
                                            Rp {{ number_format($riwayat->denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span style="color: green;">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">Selesai</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat peminjaman</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection