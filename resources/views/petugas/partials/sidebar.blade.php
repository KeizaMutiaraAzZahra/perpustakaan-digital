<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-book-half"></i>
        <span>Perpustakaan Digital</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('petugas.dashboard') }}" class="{{ request()->is('petugas/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="#">
            <i class="bi bi-book"></i> Data Buku
        </a>
        <a href="#">
            <i class="bi bi-people"></i> Data Anggota
        </a>
        
        <div class="nav-label">Transaksi</div>
        
        <a href="#">
            <i class="bi bi-arrow-up-right-circle"></i> Peminjaman
        </a>
        <a href="#">
            <i class="bi bi-arrow-down-left-circle"></i> Pengembalian
        </a>
        <a href="#">
            <i class="bi bi-cash-stack"></i> Data Denda
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit"><i class="bi bi-box-arrow-left"></i> Log Out</button>
        </form>
    </nav>
</aside>