@extends('kepala.layouts.main')

@section('title', 'Laporan Pengembalian')

@section('content')

<main class="frame-main">
<section class="laporan-peminjaman">
    <div class="card-body">
        <h2 class="-title">Laporan Pengembalian</h2>
        
        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Anggota</th>
                        <th>Judul buku</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp.0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp. 10.000</td>
                    </tr>
                    <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
</main>

@endsection