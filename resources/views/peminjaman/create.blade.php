@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="container mt-4">
    <h2 class="h5 mb-3">Tambah Peminjaman</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @include('peminjaman.partials._form')
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
