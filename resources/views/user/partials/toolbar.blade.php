<div class="row">
    {{-- Tombol Tambah User --}}
    <div class="col">
        <x-tombol-tambah label="Tambah User" href="{{ route('user.create') }}" />
    </div>

    {{-- Form Search User --}}
    <div class="col">
        <x-form-search placeholder="Cari nama/email user..." />
    </div>
</div>
