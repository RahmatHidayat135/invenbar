<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Peminjaman</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nama_peminjam }}</td>
                <td>{{ $p->barang->nama ?? '-' }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>
                <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                <td>{{ ucfirst($p->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
