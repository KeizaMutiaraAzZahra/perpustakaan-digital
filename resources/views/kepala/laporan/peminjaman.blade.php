@extends('kepala.layouts.main')

@section('title', 'Laporan Peminjaman')

@section('content')
    <main class ="frame-main">
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
                <tr>
                  <td>1</td>
                  <td>Keiza</td>
                  <td>HTML Dasar</td>
                  <td>2026-03-27</td>
                  <td class="status">Dikembalikan</td>
                </tr>
                <tr>
                <td>2</td>
                <td>Zahra</td>
                <td>CSS Lanjut</td>
                <td>2026-03-28</td>
                <td class="status">Masih Dipinjam</td>
              </tr>
            </tbody>
    </table>
  </div>
</section>
</main>
@endsection