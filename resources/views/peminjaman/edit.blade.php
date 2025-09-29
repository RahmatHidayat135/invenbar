@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="container mt-4">
    <h4>Edit Peminjaman</h4>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="barang_id" class="form-label">Barang</label>
            <select name="barang_id" class="form-control" required>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" 
                        {{ $barang->id == $peminjaman->barang_id ? 'selected' : '' }}>
                        {{ $barang->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="peminjam" class="form-label">Peminjam</label>
            <input type="text" name="peminjam" class="form-control" 
                   value="{{ $peminjaman->peminjam }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" 
                   value="{{ $peminjaman->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" 
                   value="{{ $peminjaman->tanggal_pinjam }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
