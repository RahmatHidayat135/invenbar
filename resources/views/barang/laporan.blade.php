<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Barang</title>
    @include('barang.partials.style-laporan')

</head>
<body>
    <div class="header">
        <h2>Laporan Data Barang</h2>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    @include('barang.partials.list-laporan')
</body>
</html>
