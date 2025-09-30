@csrf
<div class="mb-3">
    <label for="barang_id" class="form-label">Barang</label>
    <select name="barang_id" id="barang_id" class="form-control" required>
        <option value="">-- Pilih Barang --</option>
        @foreach($barangs as $barang)
            <option value="{{ $barang->id }}" 
                {{ old('barang_id', $peminjaman->barang_id ?? '') == $barang->id ? 'selected' : '' }}>
                {{ $barang->nama_barang }} ({{ $barang->kode_barang }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control"
           value="{{ old('nama_peminjam', $peminjaman->nama_peminjam ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="jumlah" class="form-label">Jumlah</label>
    <input type="number" name="jumlah" id="jumlah" class="form-control"
           value="{{ old('jumlah', $peminjaman->jumlah ?? 1) }}" min="1" required>
</div>

<div class="mb-3">
    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control"
           value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? '') }}" required>
</div>
