@extends('kepala.layouts.main')

@section('title', 'Data Buku')

@section('content')
            <section class="data-buku-kepala">
                <h2 class="title">Data Buku</h2>
                <hr>

            <form method="GET" class="search-bar">
                <input type="text" name="cari" placeholder="Cari Buku" value="{{ request('cari') }}">
                <button type="submit">Cari</button>
            </form>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Tahun Terbit</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($buku as $item)
                            <tr>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->penulis }}</td>
                                <td>{{ $item->tahun_terbit }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    @if ($item->stok > 0)
                                        <span class="status kembali">Tersedia</span>
                                    @else
                                        <span class="status terlambat">Habis</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;">Data buku tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $buku->links() }}
                </div>
</section>
</main>

@endsection
