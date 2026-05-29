@extends('anggota.layouts.main')

@section('title', 'Detail Peminjaman')

@section('content')
<style>
    /* SEMUA CSS LU TARUH DI DALAM TAG STYLE INI */
    
    .detail-pinjam {
        padding: 2rem;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    .detail-pinjam .main-card {
        display: flex; /* INI KUNCINYA BIAR KIRI-KANAN */
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        max-width: 1000px;
        margin: 0 auto;
    }

    .detail-pinjam .book-visual {
        flex: 1;
        background-color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
    }

    .detail-pinjam .image-wrapper img {
        width: 100%;
        max-width: 250px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .detail-pinjam .book-info-pane {
        flex: 1.5;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .detail-pinjam .stok-badge {
        display: inline-block;
        background: #e0f2fe;
        color: #0369a1;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .detail-pinjam .book-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .detail-pinjam .author-text {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 2.5rem;
    }

    .detail-pinjam .form-section {
        background: #f8fafc;
        padding: 2rem;
        border-radius: 15px;
    }

    .detail-pinjam .input-jumlah {
        width: 100px;
        height: 50px;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        text-align: center;
        font-weight: 700;
    }

    .detail-pinjam .btn-konfirmasi {
        background: #2563eb;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
        flex-grow: 1;
        text-align: center;
    }

    .detail-pinjam .btn-batal {
        color: #94a3b8;
        text-decoration: none;
        font-weight: 600;
    }

    .detail-pinjam .action-buttons {
        margin-top: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .detail-pinjam .main-card {
            flex-direction: column;
        }
    }
</style>

<div class="detail-pinjam">
    <div class="container-fluid">
        <div class="main-card">
            <div class="book-visual">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul }}">
                </div>
            </div>

            <div class="book-info-pane">
                <div class="info-header">
                    <span class="stok-badge">
                        <i class="fas fa-box me-1"></i> Stok: {{ $buku->stok }} Buku Tersedia
                    </span>
                    <h1 class="book-title">{{ $buku->judul }}</h1>
                    <p class="author-text">
                        Penulis: <strong>{{ $buku->penulis }}</strong> | Tahun: {{ $buku->tahun_terbit }}
                    </p>
                </div>

                <div class="form-section">
                    <form action="{{ route('anggota.peminjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                        
                        <div class="input-group-custom">
                            <label class="form-label" style="display:block; font-size: 0.75rem; font-weight: 800; color: #94a3b8; margin-bottom: 0.75rem;">JUMLAH PINJAM</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="number" name="jumlah" class="form-control input-jumlah" 
                                       value="1" min="1" max="{{ min($buku->stok, $sisa) }}">
                                <span class="hint-text" style="font-size: 0.85rem; color: #64748b;">Bisa pinjam lebih dari 1 buku</span>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('anggota.data-buku') }}" class="btn-batal">Batal</a>
                            <button type="submit" class="btn-konfirmasi" {{ $buku->stok <= 0 ? 'disabled' : '' }}>
                                {{ $buku->stok <= 0 ? 'Stok Habis' : 'Konfirmasi Pinjam Sekarang' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection