@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="container mt-4">
    <h2>Tambah Peminjaman</h2>

    {{-- Form create --}}
    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf {{-- wajib supaya tidak error 419 --}}

        <div class="mb-3">
            <label for="barang_id" class="form-label">Barang</label>
            <select name="barang_id" id="barang_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->nama_barang }} (Stok: {{ $item->jumlah }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
            <input type="text" name="nama_peminjam" id="nama_peminjam"
                   class="form-control" value="{{ old('nama_peminjam') }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah"
                   class="form-control" value="{{ old('jumlah') }}" required min="1">
        </div>

        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                   class="form-control" value="{{ old('tanggal_pinjam') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
