<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Barang::query();

        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
        }

        $barangs = $query->paginate(10)->withQueryString();

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();
        $barang = new Barang();

        return view('barang.create', compact('barang', 'kategori', 'lokasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tanggal_pengadaan' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
    $validated['gambar'] = $request->file('gambar')->store('gambar-barang', 'public');
}


        Barang::create($validated);

        return redirect()->route('barang.index')
                         ->with('success', 'Data Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi']);

        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();

        return view('barang.edit', compact('barang', 'kategori', 'lokasi'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tanggal_pengadaan' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // hapus file lama kalau ada
            if ($barang->gambar && File::exists(public_path('gambar-barang/' . $barang->gambar))) {
                File::delete(public_path('gambar-barang/' . $barang->gambar));
            }

            $namaFile = time() . '.' . $request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('gambar-barang'), $namaFile);
            $validated['gambar'] = $namaFile;
        }

        $barang->update($validated);

        return redirect()->route('barang.index')
                         ->with('success', 'Data Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        Gate::authorize('delete barang');

        if ($barang->gambar && File::exists(public_path('gambar-barang/' . $barang->gambar))) {
            File::delete(public_path('gambar-barang/' . $barang->gambar));
        }

        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus.');
    }

    public function cetakLaporan()
    {
        $barangs = Barang::with(['kategori', 'lokasi'])->get();

        $data = [
            'title' => 'Laporan Data Barang Inventaris',
            'date'  => date('d F Y'),
            'barangs' => $barangs
        ];

        $pdf = Pdf::loadView('barang.laporan', $data);

        return $pdf->stream('laporan-inventaris-barang.pdf');
    }
}
