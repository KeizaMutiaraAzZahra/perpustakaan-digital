@extends('kepala.layouts.main')

@section('title', 'Dashboard')

@section('content')
<section class="frame-main">
<section class="dasboard-kepala">
  <h1 class="title">DASHBOARD</h1>

  <article class="div">
      <img src="{{ asset('img/data-anggota.svg') }}" class="icon-dashboard-kepala" />
          <h2 class="teks-dashboard-kepala">Total Anggota</h2>
  </article>

  <article class="rectangle-2">
      <img src="{{ asset('img/data-petugas.svg') }}" class="icon-dashboard-kepala" />
          <h2 class="teks-dashboard-kepala">Total Petugas</h2>
  </article>

  <article class="rectangle-4">
      <img src="{{ asset('img/data-buku.svg') }}"  class="icon-dashboard-kepala" />
          <h2 class="teks-dashboard-kepala">Total Buku</h2>
  </article>

  <article class="rectangle-3">
      <img src="{{ asset('img/laporan-peminjaman.svg') }}"  class="icon-dashboard-kepala" />
          <h2 class="teks-dashboard-kepala">Buku Sedang Dipinjam</h2>
  </article>

  <article class="rectangle-5">
      <img src="{{ asset('img/laporan-denda.svg') }}"  class="icon-dashboard-kepala" />
          <h2 class="teks-dashboard-kepala">Total Denda</h2>
  </article>

  <section class="rectangle-6">
    <h3>Aktivitas Terbaru</h3>
    <p>Keiza - Meminjam Buku Laskar Pelangi</p>
  </section>

</section>
</section>
@endsection