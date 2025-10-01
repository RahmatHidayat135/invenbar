<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->lokasi->nama_lokasi ?? '-' }}</td>
                <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                <td>
                    @php
                        $kondisi = is_string($item->detail_kondisi) 
                            ? json_decode($item->detail_kondisi, true) 
                            : $item->detail_kondisi;
                    @endphp

                    @if(is_array($kondisi))
                        @foreach($kondisi as $k => $jumlah)
                            @if($jumlah > 0)
                                {{ ucfirst($k) }}: {{ $jumlah }} <br>
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
