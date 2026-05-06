@extends('kepala.layouts.main')

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

        <a href="{{ route('kepala.petugas.create') }}" class="btn-add">
            <img src="{{ asset('img/tambah.svg') }}" class="icon-tambah"/>
            <span class="text-tambah">Tambah Petugas</span>
        </a>
    </div>

    <table id="tablePetugas" class="data-table">
    <thead>
        <tr>
            <th class="text-center">No</th> <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>No Telepon</th>
            <th class="text-center">Status</th> 
            <th class="text-center">Aksi</th>   
        </tr>
    </thead>
    <tbody>
    @foreach ($petugas as $index => $p)
    <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td>{{ $p->nama }}</td>
        <td>{{ $p->alamat }}</td>
        <td>{{ $p->jenis_kelamin }}</td>
        <td>{{ $p->no_telepon }}</td>
        <td class="text-center">
            <span class="status {{ $p->user->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                {{ $p->user->status }}
            </span>
        </td>
        <td class="text-center aksi-buttons">
            <a href="{{ route('kepala.petugas.edit', $p->id) }}" class="btn-icon-edit" title="Edit">
                <i class="bi bi-pencil-square"></i>
            </a>

            <form action="{{ route('kepala.petugas.destroy', $p->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon-delete" onclick="return confirm('Yakin ingin menghapus petugas ini?')" title="Hapus">
                    <i class="bi bi-x-circle"></i>
                </button>
            </form>
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