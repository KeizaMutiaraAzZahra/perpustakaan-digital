@extends('kepala.layouts.main')

@section('title', 'Laporan Peminjaman')

@section('content')
<main class="frame-main">
    <section class="laporan-peminjaman">

        <h2 class="title">Laporan Peminjaman</h2>

        <div class="content-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($peminjaman as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td class="status">{{ $p->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Data tidak ada</td>
                </tr>
                @endforelse
              </tbody>
            </table>
        </div>

    </section>
</main>
@endsection