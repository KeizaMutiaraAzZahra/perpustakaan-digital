@extends('petugas.layouts.main')

@section('title', 'Data Anggota')

@section('content')
<section class="data-anggota-petugas">
    <div class="header-section">
        <h2 class="title">Data Anggota</h2>
    </div>

    <div class="table-card">
        <div class="table-controls">
            <form action="{{ route('petugas.anggota.index') }}" method="GET" class="search-box">
                <input type="text" name="search" placeholder="Cari Anggota" value="{{ request('search') }}">
                <button type="submit" class="btn-cari">Cari</button>
            </form>
            <a href="{{ route('petugas.anggota.create') }}"  class="btn-tambah">+ Tambah Anggota</a>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                <th width="50">No</th> 
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>No_telepon</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->kelas }}</td>
                    <td>{{ $row->jurusan }}</td>
                    <td>{{ $row->no_telepon }}</td>
                    <td>
                        <span class="badge {{ $row->status == 'Aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                            {{ $row->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn-detail">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-text">Data anggota tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>\
        <div class="mt-3">
            {{ $anggota->links() }}
        </div>
    </div>
</section>
@endsection