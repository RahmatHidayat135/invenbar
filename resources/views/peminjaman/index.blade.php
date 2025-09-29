@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
<div class="container mt-4">

    <h2 class="h5 mb-3">Peminjaman</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Peminjaman
            </a>
            <a href="{{ route('peminjaman.laporan') }}" target="_blank" class="btn btn-success">
                <i class="bi bi-printer"></i> Cetak Laporan Peminjaman
            </a>
        </div>

        {{-- Search --}}
        <form action="{{ route('peminjaman.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control me-2" placeholder="Cari nama/kode barang...">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Barang</th>
                            <th>Nama Peminjam</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->barang?->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                            <td>{{ $item->nama_peminjam }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td>
                                @if($item->status == 'Dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol kembalikan --}}
                                @if($item->status == 'Dipinjam')
                                    <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
                                    </form>
                                @endif

                                {{-- Tombol hapus --}}
                                <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                            class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
