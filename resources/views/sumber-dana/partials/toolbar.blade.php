<div class="row">
    <div class="col">
        @can('manage sumber_dana')
            <x-tombol-tambah 
                label="Tambah Sumber Dana" 
                href="{{ route('sumber-dana.create') }}" 
            />

        @endcan
    </div>

    <div class="col">
        <x-form-search placeholder="Cari nama sumber dana..." />
    </div>
</div>
