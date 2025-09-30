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
