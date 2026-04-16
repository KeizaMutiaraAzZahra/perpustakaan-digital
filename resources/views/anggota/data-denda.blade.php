@extends('anggota.layouts.main')

@section('title', 'Data Denda')

@section('content')

<div class="data-denda-anggota">
    <h2 class="section-title">Denda</h2>

    @if(($totalTagihan ?? 0) > 0)
        <div class="alert-tagihan">
            <div class="alert-content">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <p class="alert-label">Total Tagihan Denda Anda</p>
                    <h3 class="alert-amount">Rp. {{ number_format($totalTagihan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    @else
        <div class="alert-tagihan" style="background: #d1e7dd; border-left: 5px solid #0f5132; color: #0f5132;">
            <div class="alert-content">
                <i class="bi bi-check-circle-fill"></i>
                <div>
                    <p class="alert-label" style="color: #0f5132;">Status Denda</p>
                    <h3 class="alert-amount" style="color: #0f5132;">Lunas / Tidak Ada Tagihan</h3>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('anggota.data-denda') }}" method="GET">
        <div class="filter-container">
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Belum Bayar" {{ request('status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
            </select>

            <div class="search-wrapper">
                <div class="search-box">
                    <input type="text" name="cari" placeholder="Cari Judul Buku..." value="{{ request('cari') }}">
                </div>
                <button type="submit" class="btn-search">Cari</button>
            </div>
        </div>
</form>

    <div class="table-card mb-4">
        <h4 class="table-title">Tagihan Anda (Perlu Dibayar)</h4>
        <div class="table-responsive">
            <table class="denda-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Terlambat</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihanAktif as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ $item->hari_terlambat }} Hari</td>
                        <td>Rp. {{ number_format($item->total_denda, 0, ',', '.') }}</td>
                        <td><span class="badge bg-danger">Belum Bayar</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Tidak ada tagihan denda aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-card">
        <h4 class="table-title">Riwayat Pembayaran</h4>
        <div class="table-responsive">
            <table class="denda-table">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- PAKAI $riwayatDenda --}}
                    @forelse($riwayatDenda as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>Rp. {{ number_format($item->total_denda, 0, ',', '.') }}</td>
                        <td><span class="badge bg-success">Sudah Dibayar (Offline)</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Belum ada riwayat denda.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
        </div>

    @if(($totalTagihan ?? 0) > 0)
    <div class="action-container">
        <div class="total-summary">
            <p><strong>Denda: Rp {{ number_format($totalTagihan, 0, ',', '.') }}</strong></p>
            <small style="color: gray;">
                Pembayaran dilakukan secara langsung di meja sirkulasi perpustakaan
            </small>
        </div>
    </div>
@endif
    
</div>

@endsection