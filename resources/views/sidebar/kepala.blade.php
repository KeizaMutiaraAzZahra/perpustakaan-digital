<nav class="frame-wrapper" aria-label="Navigasi Utama">
  <div class="frame-2">
    <a href="/dashboard/kepala" class="nav-item">
        <img src="{{ asset('img/dashboard.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Dashboard </h1>
    </a>

    <a href="/data-buku/kepala" class="nav-item">
        <img src="{{ asset('img/data-buku.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Data Buku </h1>
    </a>

    <a href="#" class="nav-item">
        <img src="{{ asset('img/data-anggota.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Data Anggota </h1>
    </a>

    <a href="{{ route('petugas.index') }}" class="nav-item">
        <img src="{{ asset('img/data-petugas.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Data Petugas </h1>
    </a>

    <a href="/laporan/peminjaman" class="nav-item">
        <img src="{{ asset('img/laporan-peminjaman.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Laporan Peminjaman </h1>
    </a>

    <a href="#" class="nav-item">
        <img src="{{ asset('img/laporan-pengembalian.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Laporan Pengembalian </h1>
    </a>

    <a href="#" class="nav-item">
        <img src="{{ asset('img/laporan-denda.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Laporan Denda </h1>
    </a>

    <a href="#" class="nav-item">
        <img src="{{ asset('img/logout.svg') }}" class="icon-sidebar" />
            <h1 class="sidebar-teks"> Logout </h1>
    </a>

  </div>

</nav>