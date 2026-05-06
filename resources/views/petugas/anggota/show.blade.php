@extends('petugas.layouts.main')

@section('title', 'Detail Anggota')

@section('content')
<div class="main-content-detail">
    <div class="card-detail">
        <h2 class="title-section">Detail Anggota</h2>
        
        <div class="table-container">
            <h3 class="table-header">Detail Anggota</h3>
            <table class="detail-table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $anggota->nama ?? 'Nama Anggota' }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $anggota->kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>{{ $anggota->jurusan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>No_Telepon</td>
                    <td>:</td>
                    <td>{{ $anggota->no_telp ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>
                        <span class="badge badge-nonaktif">Nonaktif</span>
                        <span class="badge badge-aktif">Aktif</span>
                    </td>
                </tr>
            </table>

            <div class="riwayat-section">
                <p class="riwayat-title">Riwayat Peminjaman</p>
                <ul class="riwayat-list">
                    <li>Laskar Pelangi (Dipinjam)</li>
                    <li>Matematika (Dikembalikan)</li>
                </ul>
            </div>
        </div>

        <div class="action-buttons">
            <button class="btn btn-edit">Edit</button>
            <button class="btn btn-nonaktifkan">Nonaktifkan</button>
            <button class="btn btn-batal-detail">Batal</button>
        </div>
    </div>
</div>

@endsection