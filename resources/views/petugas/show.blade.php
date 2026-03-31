@extends('layouts.main')

@section('title', 'Detail Petugas')

@section('content')

<main class="frame-main">
<section class="detail-petugas">

    <h1 class="title">Detail Petugas</h1>

    <!-- CARD -->
    <div class="card">

      <h2 class="">Detail Petugas</h2>

      <!-- DATA -->
      <div class="detail-list">

        <div class="detail-item">
          <span class="label">Nama</span>
          <span class="separator">:</span>
          <span class="value">{{ $petugas->nama }}</span>
        </div>

        <div class="detail-item">
          <span class="label">Alamat</span>
          <span class="separator">:</span>
          <span class="value">{{ $petugas->alamat }}</span>
        </div>

        <div class="detail-item">
          <span class="label">Jenis Kelamin</span>
          <span class="separator">:</span>
          <span class="value">{{ $petugas->jenis_kelamin }}</span>
        </div>

        <div class="detail-item">
          <span class="label">No Telepon</span>
          <span class="separator">:</span>
          <span class="value">{{ $petugas->no_telepon }}</span>
        </div>

        <div class="detail-item">
          <span class="label">Status</span>
          <span class="separator">:</span>

          <div class="status-group">
            @if($petugas->status == 'aktif')
                <span class="status aktif">Aktif</span>
            @else
                <span class="status nonaktif">Nonaktif</span>
            @endif
          </div>
        </div>

      </div>

    </div>

    <!-- ACTION BUTTON -->
    <div class="actions">
      <a href="{{ route('petugas.edit', $petugas->id) }}" class="btn edit">Edit</a>
      <form action="{{ route('petugas.destroy', $petugas->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button class="btn danger">Hapus</button>
      </form>
      <a href="{{ route('petugas.index') }}" class="btn success">Batal</a>
    </div>

</section>
</main>

@endsection