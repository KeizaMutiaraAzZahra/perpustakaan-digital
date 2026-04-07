@extends('kepala.layouts.main')

@section('title', 'Data Anggota')

@section('content')

 <div class="data-anggota-kepala">
    <div class="header-section">
        <h2 class="title">Data Anggota</h2>
        <hr class="line">
    </div>

    <div class="top-bar">
        <form action="{{ route('kepala.data-anggota') }}" method="GET" class="search-wrapper">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="cari" placeholder="Cari Anggota" value="{{ request('cari') }}">
            </div>
            <button type="submit" class="btn-cari">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>No_telepon</th>
                    <th>Tgl. Daftar</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $index => $a)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->kelas ?? '-' }}</td>
                    <td>{{ $a->jurusan ?? '-' }}</td>
                    <td>{{ $a->no_telepon ?? '-' }}</td>
                    <td>{{ $a->created_at->format('d-m-Y') }}</td>
                    <td class="text-center">
                        <span class="badge status-aktif">Aktif</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Data tidak ditemukan</td>
                </tr>
@endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection