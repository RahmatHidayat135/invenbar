<x-main-layout :title-page="__('Detil Barang')">
    <div class="card my-5 shadow">
        <div class="card-body">
            <div class="row">
                <!-- Bagian Gambar Barang -->
                <div class="col-md-4 text-center mb-3">
                    @include('barang.partials.info-gambar-barang')
                </div>

                <!-- Bagian Info Data Barang -->
                <div class="col-md-8">
                    @include('barang.partials.info-data-barang')
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning me-2">
                    ✏️ Edit
                </a>
                <x-tombol-kembali :href="route('barang.index')" />
            </div>
        </div>
    </div>
</x-main-layout>
