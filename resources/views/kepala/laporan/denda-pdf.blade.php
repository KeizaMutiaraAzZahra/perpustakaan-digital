<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .kop { text-align: center; }
        .kop h2 { margin: 0; }
        hr { border: 1px solid black; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="kop">
    <h2>LAPORAN DENDA</h2>
    <p>Sistem Perpustakaan Digital</p>
</div>

<hr>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tanggal Kembali</th>
            <th>Total Denda</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->anggota->nama ?? '-' }}</td>
            <td>{{ $item->buku->judul ?? '-' }}</td>
            <td>
                {{ $item->tanggal_kembali 
                    ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') 
                    : '-' }}
            </td>
            <td>Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
            <td>
                @if(($item->denda ?? 0) > 0)
                    Belum Bayar
                @else
                    Lunas / Tidak Ada Denda
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Tidak ada data denda</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 60px;">
    <table width="100%" style="border: none;">
        <tr>
            <!-- KIRI -->
            <td style="text-align: left; border: none;">
                Mengetahui,<br>
                Kepala Perpustakaan
                <br><br><br><br>
                <b>( Nama Kepala Perpustakaan )</b>
            </td>

            <!-- KANAN -->
            <td style="text-align: right; border: none;">
                Banjar, {{ date('d F Y') }}<br>
                Petugas Perpustakaan
                <br><br><br><br>
                <b>( Nama Petugas )</b>
            </td>
        </tr>
    </table>
</div>

</body>
</html>