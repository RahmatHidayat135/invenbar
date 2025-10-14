@csrf
<div class="mb-3">
    <x-form-input 
        label="Nama Sumber Dana" 
        name="nama_sumber_dana" 
        :value="$sumberDana->nama_sumber_dana ?? ''" 
    />
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? __('Update') : __('Simpan') }}
    </x-primary-button>

    <x-tombol-kembali :href="route('sumber-dana.index')" />
</div>
