<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Nama Peminjam</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peminjamans as $index => $peminjaman)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $peminjaman->barang->nama_barang ?? '-' }}</td>
                <td>{{ $peminjaman->nama_peminjam }}</td>
                <td>{{ $peminjaman->jumlah }}</td>
                <td>{{ $peminjaman->tanggal_pinjam }}</td>
                <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
                <td>{{ $peminjaman->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
