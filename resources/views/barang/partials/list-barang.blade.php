<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Sumber Dana</th> 
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>&nbsp;</th>
        </tr>
    </x-slot>

    @forelse ($barangs as $index => $barang)
        <tr>
            <td>{{ $barangs->firstItem() + $index }}</td>
            <td>{{ $barang->kode_barang }}</td>
            <td>{{ $barang->nama_barang }}</td>
            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $barang->lokasi->nama_lokasi ?? '-' }}</td>
            <td>{{ $barang->sumberDana->nama_sumber_dana ?? '-' }}</td> 
            <td>{{ $barang->jumlah }} {{ $barang->satuan }}</td>
            <td>
                @if($barang->detail_kondisi)
                    @php
                        $kondisiData = is_array($barang->detail_kondisi)
                            ? $barang->detail_kondisi
                            : (json_decode($barang->detail_kondisi, true) ?? []);
                    @endphp

                    @foreach($kondisiData as $kondisi => $jumlah)
                        @if($jumlah > 0)
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
                        @endif
                    @endforeach

                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td class="text-end">
                @can('manage barang')
                    <x-tombol-aksi href="{{ route('barang.show', $barang->id) }}" type="show" />
                    <x-tombol-aksi href="{{ route('barang.edit', $barang->id) }}" type="edit" />
                @endcan
                @can('delete barang')
                    <x-tombol-aksi href="{{ route('barang.destroy', $barang->id) }}" type="delete" />
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">
                <div class="alert alert-danger">
                    Data barang belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>
