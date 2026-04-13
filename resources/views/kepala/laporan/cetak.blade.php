<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perpustakaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .footer { margin-top: 30px; float: right; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN {{ strtoupper($status) }}</h2>
        <p>Sistem Perpustakaan Digital</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->anggota->nama ?? '-' }}</td>
                <td>{{ $p->buku->judul ?? '-' }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>
                <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                <td>Rp {{ number_format($p->denda, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Tasikmalaya, {{ date('d F Y') }}</p>
        <p>Kepala Perpustakaan,</p>
        <br><br><br>
        <p><strong>( {{ Auth::user()->name }} )</strong></p>
    </div>
</body>
</html>