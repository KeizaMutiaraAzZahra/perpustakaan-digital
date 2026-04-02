@extends('kepala.layouts.main')

@section('title', 'Laporan Pengembalian')

@section('content')

<div class="laporan-pengembalian">
    <div class="content-wrapper">
        <div class="report-header">
            <h2 class="report-title">Laporan Pengembalian</h2>
            <hr class="title-line">
        </div>

        <div class="table-container">
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
                        <td>1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp. 0</td>
                    </tr>
                    <tr>
                        <td>2</td>
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
</div>
@endsection