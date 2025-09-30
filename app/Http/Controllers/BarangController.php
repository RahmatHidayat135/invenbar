<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Tampilkan daftar barang
     */
    public function index()
    {
        $barangs = Barang::with(['kategori', 'lokasi'])->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $lokasi   = Lokasi::all();

        return view('barang.create', compact('kategori', 'lokasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id'   => 'required|exists:lokasis,id',
            'jumlah'      => 'required|integer|min:1',
            'satuan'      => 'required|string',
            'tanggal_pengadaan' => 'required|date',
            'gambar'      => 'nullable|image',
            'detail_kondisi.baik' => 'nullable|integer|min:0',
            'detail_kondisi.rusak_ringan' => 'nullable|integer|min:0',
            'detail_kondisi.rusak_berat' => 'nullable|integer|min:0',
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        // Simpan kondisi sebagai JSON
        $validated['detail_kondisi'] = json_encode([
            'baik'         => $request->input('detail_kondisi.baik', 0),
            'rusak_ringan' => $request->input('detail_kondisi.rusak_ringan', 0),
            'rusak_berat'  => $request->input('detail_kondisi.rusak_berat', 0),
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil disimpan!');
    }

    /**
     * Tampilkan detail barang
     */
    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi']);
        return view('barang.show', compact('barang'));
    }

    /**
     * Tampilkan form edit barang
     */
    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $lokasi   = Lokasi::all();

        return view('barang.edit', compact('barang', 'kategori', 'lokasi'));
    }

    /**
     * Update barang
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang'       => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'       => 'required|string|max:255',
            'kategori_id'       => 'required|exists:kategoris,id',
            'lokasi_id'         => 'required|exists:lokasis,id',
            'jumlah'            => 'required|integer|min:1',
            'satuan'            => 'required|string|max:50',
            'tanggal_pengadaan' => 'required|date',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'detail_kondisi'    => 'required|array',
        ]);

        $jumlah = (int) $request->jumlah;
        $detailKondisi = $request->detail_kondisi;
        $totalKondisi = array_sum($detailKondisi);

        if ($totalKondisi !== $jumlah) {
            return back()
                ->withInput()
                ->withErrors(['detail_kondisi' => 'Jumlah kondisi harus sama dengan jumlah total unit.']);
        }

        // Upload gambar baru
        $gambarPath = $barang->gambar;
        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $gambarPath = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update([
            'kode_barang'       => $request->kode_barang,
            'nama_barang'       => $request->nama_barang,
            'kategori_id'       => $request->kategori_id,
            'lokasi_id'         => $request->lokasi_id,
            'jumlah'            => $jumlah,
            'satuan'            => $request->satuan,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'gambar'            => $gambarPath,
            'detail_kondisi'    => json_encode($detailKondisi),
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Hapus barang
     */
    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}
