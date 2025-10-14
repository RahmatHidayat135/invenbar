<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th style="width: 30%;">Nama Barang</th>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $barang->lokasi->nama_lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Sumber Dana</th>
            <td>{{ $barang->sumberDana?->nama_sumber_dana ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $barang->jumlah }} {{ $barang->satuan }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>
                @php
                    // Pastikan detail_kondisi berbentuk array
                    $kondisiData = is_array($barang->detail_kondisi)
                        ? $barang->detail_kondisi
                        : (json_decode($barang->detail_kondisi, true) ?? []);

                    // Filter kondisi agar hanya tampil yang jumlahnya > 0
                    $kondisiData = array_filter($kondisiData, fn($jumlah) => $jumlah > 0);
                @endphp

                @if(empty($kondisiData))
                    <span class="text-muted">-</span>
                @else
                    @foreach($kondisiData as $kondisi => $jumlah)
                        @php
                            $kondisiKey = strtolower(str_replace(' ', '_', $kondisi));
                            $badgeClass = match($kondisiKey) {
                                'baik' => 'bg-success',
                                'rusak_ringan' => 'bg-warning text-dark',
                                'rusak_berat' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                        @endphp

                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst(str_replace('_', ' ', $kondisi)) }}: {{ $jumlah }}
                        </span><br>
                    @endforeach
                @endif
            </td>
        </tr>

        <tr>
            <th>Tanggal Pengadaan</th>
            <td>{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <th>Terakhir Diperbarui</th>
            <td>{{ $barang->updated_at->translatedFormat('d F Y, H:i') }}</td>
        </tr>
    </tbody>
</table>
