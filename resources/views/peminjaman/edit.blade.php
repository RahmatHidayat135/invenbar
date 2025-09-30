@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="container mt-4">
    <h2 class="h5 mb-3">Edit Peminjaman</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('peminjaman.partials._form')
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
