<div class="nav-wrapper">
    <header class="nav-header">
        <i class="bi bi-book-half"></i>
        <h1>Perpustakaan Digital</h1>
    </header>

    <nav class="nav-sidebar">
        <a href="{{ route('anggota.dashboard') }}" class="nav-item {{ request()->is('kepala/dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('anggota.buku.index') }}" class="nav-item">
            <i class="bi bi-book"></i> <span>Data Buku</span>
        </a>
        <a href="{{ route('anggota.anggota.index') }}" class="nav-item">
            <i class="bi bi-people"></i> <span>Data Anggota</span>
        </a>

        <a href="{{ route('anggota.peminjaman') }}" class="nav-item">
            <i class="bi bi-box-arrow-in-up-right"></i> <span>Data Peminjaman</span>
        </a>
        <a href="{{ route('anggota.pengembalian') }}" class="nav-item">
           <i class="bi bi-box-arrow-up-right"></i> <span>Data Pengembalian</span>
        </a>
        <a href="{{ route('anggota.denda') }}" class="nav-item">
            <i class="bi bi-journal-x"></i> <span>Data Denda</span>
        </a>

        <div class="spacer"></div> <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</div>