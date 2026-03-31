@extends('layouts.main')

@section('title', 'data-petugas')

@section('content')

<main class="frame-main">
  <section class="data-petugas">

    <h2 class="title">Data Petugas</h2>

    <!-- TOP BAR -->
    <div class="top-bar">
      <div class="search-box">
        <img src="{{ asset('img/pencarian.svg') }}" />
        <input type="text" id="searchInput" placeholder="Cari Petugas">
      </div>

      <button onclick="searchTable()" class="btn-search">Cari</button>

      <button class="btn-add">
          <a href="/petugas/create">
              <img src="{{ asset('img/tambah.svg') }}" class="icon-tambah"/>
                  <span class="text-tambah"> Tambah Petugas </span>
          </a>
      </button>
    </div>

    <table id="tablePetugas" class="data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>No Telepon</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($petugas as $index => $p)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->alamat }}</td>
            <td>{{ $p->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}</td>
            <td>{{ $p->no_telepon }}</td>
            <td class="status {{ strtolower($p->status) }}">{{ $p->status }}</td>
            <td>
                <a href="{{ route('petugas.show', $p->id) }}" class="btn-detail">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

  </section>
</main>
@endsection
<script>
function searchTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let table = document.getElementById("tablePetugas");
    let rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        let text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(input) ? "" : "none";
    }
}
</script>