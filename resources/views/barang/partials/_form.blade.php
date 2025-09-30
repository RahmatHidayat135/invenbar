@csrf
<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Kode Barang" name="kode_barang" :value="$barang->kode_barang ?? ''" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Nama Barang" name="nama_barang" :value="$barang->nama_barang ?? ''" />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-select label="Kategori" name="kategori_id" :value="$barang->kategori_id ?? ''"
            :options="$kategori" optionLabel="nama_kategori" optionValue="id" />
    </div>
    <div class="col-md-6">
        <x-form-select label="Lokasi" name="lokasi_id" :value="$barang->lokasi_id ?? ''"
            :options="$lokasi" optionLabel="nama_lokasi" optionValue="id" />
    </div>
</div>

{{-- Jumlah total unit --}}
<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Jumlah Unit Total" name="jumlah" :value="$barang->jumlah ?? 1" type="number" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Satuan" name="satuan" :value="$barang->satuan ?? ''" />
    </div>
</div>

{{-- Kondisi per jumlah --}}
@php
    // Ambil data kondisi dari old() atau dari database
    $kondisi = old('detail_kondisi', $barang->detail_kondisi ?? []);
@endphp
<div class="mb-3">
    <label class="form-label fw-bold">Set Kondisi Unit</label>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kondisi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Baik</td>
                    <td>
                        <input type="number" name="detail_kondisi[baik]" 
                            value="{{ $kondisi['baik'] ?? 0 }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Rusak Ringan</td>
                    <td>
                        <input type="number" name="detail_kondisi[rusak_ringan]" 
                            value="{{ $kondisi['rusak_ringan'] ?? 0 }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Rusak Berat</td>
                    <td>
                        <input type="number" name="detail_kondisi[rusak_berat]" 
                            value="{{ $kondisi['rusak_berat'] ?? 0 }}" class="form-control">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <small class="text-muted">Jumlah kondisi harus sama dengan jumlah total unit.</small>
</div>

{{-- Tanggal + Gambar --}}
<div class="row mb-3">
    <div class="col-md-6">
        @php
            $tanggal = isset($barang) && $barang->tanggal_pengadaan
                ? date('Y-m-d', strtotime($barang->tanggal_pengadaan))
                : null;
        @endphp
        <x-form-input label="Tanggal Pengadaan" name="tanggal_pengadaan"
            type="date" :value="$tanggal" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Gambar Barang" name="gambar" type="file" />
        @isset($barang->gambar)
            <small class="text-muted">Gambar saat ini:</small><br>
            <img src="{{ asset('storage/'.$barang->gambar) }}" alt="Gambar Barang" width="120" class="mt-1 rounded">
        @endisset
    </div>
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? __('Update') : __('Simpan') }}
    </x-primary-button>

    <x-tombol-kembali :href="route('barang.index')" />
</div>
