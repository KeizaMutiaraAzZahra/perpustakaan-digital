@extends('anggota.layouts.main')

@section('title', 'Form Pengembalian')

@section('content')
<div class="-form-pengembalian-anggota-container">
    <h2 class="-form-pengembalian-anggota-title">Pengembalian</h2>
    
    <div class="-form-pengembalian-anggota-card">
        <h3 class="-form-pengembalian-anggota-subtitle">Form Pengembalian</h3>
        
        <form action="{{ route('anggota.proses-pengembalian', $data->id) }}" method="POST">
            @csrf
            <div class="-form-pengembalian-anggota-group">
                <label>Nama</label>
                <span>:</span>
                <input type="text" value="{{ auth()->user()->name }}" readonly>
            </div>

            <div class="-form-pengembalian-anggota-group">
                <label>Buku</label>
                <span>:</span>
                <input type="text" value="{{ $data->buku->judul }}" readonly>
            </div>

            <div class="-form-pengembalian-anggota-group">
                <label>Tanggal Pinjam</label>
                <span>:</span>
                <input type="text" value="{{ $data->tanggal_pinjam->format('d-m-Y') }}" readonly>
            </div>

            <div class="-form-pengembalian-anggota-group">
                <label>Jatuh Tempo</label>
                <span>:</span>
                <input type="text" value="{{ $data->jatuh_tempo->format('d-m-Y') }}" readonly>
            </div>

            <div class="-form-pengembalian-anggota-group">
                <label>Status</label>
                <span>:</span>
                <div class="-form-pengembalian-anggota-status">
                    {{-- Logika sederhana untuk cek keterlambatan --}}
                    @if(now() > $data->jatuh_tempo)
                        <span class="badge-terlambat">Terlambat</span>
                    @else
                        <span class="badge-tepat">Tepat Waktu</span>
                    @endif
                </div>
            </div>

            <div class="-form-pengembalian-anggota-group">
                <label>Denda</label>
                <span>:</span>
                <input type="text" value="Rp {{ number_format($denda, 0, ',', '.') }}" readonly>
            </div>

            <div class="-form-pengembalian-anggota-footer">
                <button type="submit" class="-form-pengembalian-anggota-btn">Konfirmasi Pengembalian</button>
            </div>
        </form>
    </div>
</div>
@endsection
