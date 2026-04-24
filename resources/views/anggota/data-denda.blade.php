@extends('anggota.layouts.main')

@section('title', 'Data Denda')

@section('content')

<div class="data-denda-anggota">
    <h2 class="section-title">Denda</h2>

    <div class="alert-tagihan">
        <div class="alert-content">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <p class="alert-label">Total Tagihan Denda Anda</p>
                <h3 class="alert-amount">Rp. {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="filter-container">
        <select class="filter-select">
            <option>Semua Status</option>
            <option>Belum Bayar</option>
            <option>Proses</option>
        </select>
        <select class="filter-select">
            <option>Semua Waktu</option>
        </select>
        <div class="search-box">
            <input type="text" placeholder="Cari Denda">
            <button class="btn-search">Cari</button>
        </div>
    </div>

    <div class="table-card">
        <h4 class="table-title">Tagihan Anda</h4>
        <div class="table-responsive">
            <table class="denda-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Terlambat</th>
                        <th>Denda/hari</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarDenda as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->jatuh_tempo)->diffInDays($item->tanggal_kembali ?? now()) }} Hari</td>
                        <td>Rp. 2.000</td>
                        <td>Rp. {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td><span class="badge-status">{{ $item->status }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada tagihan denda.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-footer">
                        <td colspan="4" class="text-right">Total</td>
                        <td>Total</td>
                        <td>Rp. {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="action-container">
        <div class="total-summary">
            <button class="btn-bayar" onclick="alert('Silahkan lakukan pembayaran tunai ke petugas di meja sirkulasi perpustakaan dengan membawa kartu anggota.')">
                Bayar Denda
            </button>
        </div>
    </div>
</div>

@endsection