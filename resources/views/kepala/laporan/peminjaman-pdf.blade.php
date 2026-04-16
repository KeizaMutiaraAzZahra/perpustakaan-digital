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

        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="kop">
    <h2>LAPORAN PEMINJAMAN</h2>
    <p>Sistem Perpustakaan Digital</p>
</div>

<hr>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
        </tr>
    </thead>
    <<tbody>
        @forelse($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->anggota->nama }}</td>
            <td>{{ $item->buku->judul }}</td>
            <td>{{ $item->tanggal_pinjam }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Data tidak ada</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="ttd">
    <p>Banjar, {{ date('d F Y') }}</p>
    <p>Kepala Perpustakaan,</p>

    <br><br><br>

    <p><b>( Kepala Perpustakaan )</b></p>
</div>

</body>
</html>