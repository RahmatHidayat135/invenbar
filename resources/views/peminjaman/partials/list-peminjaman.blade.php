<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Nama Peminjam</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>&nbsp;</th>
        </tr>
    </x-slot>

    @forelse ($peminjamans as $index => $peminjaman)
        <tr>
            <td>{{ $peminjamans->firstItem() + $index }}</td>
            <td>{{ $peminjaman->barang->nama_barang }}</td>
            <td>{{ $peminjaman->nama_peminjam }}</td>
            <td>{{ $peminjaman->jumlah }}</td>
            <td>{{ $peminjaman->tanggal_pinjam }}</td>
            <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
            <td>
                @if ($peminjaman->status == 'Dipinjam')
                    <span class="badge bg-warning">Dipinjam</span>
                @else
                    <span class="badge bg-success">Dikembalikan</span>
                @endif
            </td>
            <td class="text-end">
                @if ($peminjaman->status == 'Dipinjam')
        <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
        </form>
                @endif


                {{-- Tombol Hapus pakai komponen modal delete --}}
                <x-tombol-aksi href="{{ route('peminjaman.destroy', $peminjaman->id) }}" type="delete" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">
                <div class="alert alert-danger">
                    Data peminjaman belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>
