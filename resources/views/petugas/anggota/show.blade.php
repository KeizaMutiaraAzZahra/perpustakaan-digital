@extends('petugas.layouts.main')

@section('title', 'Detail Anggota')

@section('content')
<div class="main-content-detail">
    <div class="card-detail">
        <h2 class="title-section">Detail Anggota</h2>
        
        <div class="table-container">
            <h3 class="table-header">Informasi Profil</h3>
            <table class="detail-table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $anggota->nama }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $anggota->kelas }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>{{ $anggota->jurusan }}</td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td>{{ $anggota->no_telepon }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>
                        @if($anggota->status == 'Aktif')
                            <span class="badge badge-aktif">Aktif</span>
                        @else
                            <span class="badge badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Bagian Riwayat Peminjaman (Opsional kalau lu udah buat relasinya) --}}
            <div class="riwayat-section mt-4">
                <p class="riwayat-title">Riwayat Peminjaman Terbaru</p>
                <ul class="riwayat-list">
                    @forelse($anggota->user->peminjaman ?? [] as $pinjam)
                        <li>{{ $pinjam->buku->judul }} ({{ $pinjam->status }})</li>
                    @empty
                        <li class="text-muted">Belum ada riwayat peminjaman.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="action-buttons mt-4">
            <a href="{{ route('petugas.anggota.edit', $anggota->id) }}" class="btn btn-edit">Edit</a>
            
            <a href="{{ route('petugas.anggota.index') }}" class="btn btn-batal-detail text-decoration-none">Kembali</a>
        </div>
    </div>
</div>
@endsection