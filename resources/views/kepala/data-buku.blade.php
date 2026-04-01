@extends('kepala.layouts.main')

@section('title', 'dashboard')

@section('content')

        <main class="frame-main">
            <section class="data-buku-kepala">
            <section class="content-card">
                <h2 class="title">Data Buku</h2>
                <hr>

                <div class="search-bar">
                    <input type="text" placeholder="Cari Buku">
                    <button>Cari</button>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Jumlah Dipinjam</th>
                            <th>Status</th>
                            <th>Total Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><span class="status kembali">Kembali</span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><span class="status terlambat">Terlambat</span></td>
                            <td></td>
                        </tr>
                        <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                    </tbody>
                </table>
            </section>
</section>
</main>

@endsection
