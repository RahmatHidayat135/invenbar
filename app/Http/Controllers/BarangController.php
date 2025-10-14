<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    /**
     * 🔹 Tampilkan daftar barang
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $barangs = Barang::with(['kategori', 'lokasi', 'sumberDana'])
            ->when($search, function ($query, $search) {
                $query->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhereHas('kategori', fn($q) => $q->where('nama_kategori', 'like', "%{$search}%"))
                    ->orWhereHas('lokasi', fn($q) => $q->where('nama_lokasi', 'like', "%{$search}%"))
                    ->orWhereHas('sumberDana', fn($q) => $q->where('nama_sumber_dana', 'like', "%{$search}%"));
            })
            ->paginate(10);

        return view('barang.index', compact('barangs'));
    }

    /**
     * 🔹 Form tambah barang
     */
    public function create()
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();
        $sumberDana = SumberDana::all();

        return view('barang.create', compact('kategori', 'lokasi', 'sumberDana'));
    }

    /**
     * 🔹 Simpan barang baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'sumber_dana_id' => 'required|exists:sumber_danas,id',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'tanggal_pengadaan' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'detail_kondisi.baik' => 'nullable|integer|min:0',
            'detail_kondisi.rusak_ringan' => 'nullable|integer|min:0',
            'detail_kondisi.rusak_berat' => 'nullable|integer|min:0',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $validated['detail_kondisi'] = [
            'baik' => $request->input('detail_kondisi.baik', 0),
            'rusak_ringan' => $request->input('detail_kondisi.rusak_ringan', 0),
            'rusak_berat' => $request->input('detail_kondisi.rusak_berat', 0),
        ];

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil disimpan!');
    }

    /**
     * 🔹 Tampilkan detail barang
     */
    public function show(Barang $barang)

        {

            $barang->load(['kategori', 'lokasi', 'sumberDana']);

            return view('barang.show', compact('barang'));

        }


    /**
     * 🔹 Form edit barang
     */
    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();
        $sumberDana = SumberDana::all();

        if ($barang->gambar && !str_starts_with($barang->gambar, 'storage/')) {
            $barang->gambar = 'storage/' . $barang->gambar;
        }

        return view('barang.edit', compact('barang', 'kategori', 'lokasi', 'sumberDana'));
    }

    /**
     * 🔹 Update data barang
     */
    public function update(Request $request, Barang $barang)
{
    // ✅ Validasi input
    $validated = $request->validate([
        'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
        'nama_barang' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'lokasi_id' => 'required|exists:lokasis,id',
        'sumber_dana_id' => 'nullable|exists:sumber_danas,id',
        'jumlah' => 'required|integer|min:1',
        'satuan' => 'required|string|max:50',
        'tanggal_pengadaan' => 'required|date',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'detail_kondisi' => 'nullable|array',
    ]);

    // ✅ Pastikan setiap kondisi punya nilai (kalau kosong, isi 0)
    $detailKondisi = [
        'baik' => (int)($request->input('detail_kondisi.baik') ?? 0),
        'rusak_ringan' => (int)($request->input('detail_kondisi.rusak_ringan') ?? 0),
        'rusak_berat' => (int)($request->input('detail_kondisi.rusak_berat') ?? 0),
    ];

    // ✅ Cek total kondisi
    $totalKondisi = array_sum($detailKondisi);
    if ($totalKondisi !== (int)$request->jumlah) {
        return back()
            ->withInput()
            ->withErrors(['detail_kondisi' => 'Jumlah kondisi harus sama dengan jumlah total unit.']);
    }

    // ✅ Update / ganti gambar bila ada upload baru
    $gambarPath = $barang->gambar;
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama kalau ada
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        // Simpan gambar baru ke storage/public/barang
        $gambarPath = $request->file('gambar')->store('barang', 'public');
    }

    // ✅ Update semua data barang
    $barang->update([
        'kode_barang' => $validated['kode_barang'],
        'nama_barang' => $validated['nama_barang'],
        'kategori_id' => $validated['kategori_id'],
        'lokasi_id' => $validated['lokasi_id'],
        'sumber_dana_id' => $validated['sumber_dana_id'] ?? null,
        'jumlah' => $validated['jumlah'],
        'satuan' => $validated['satuan'],
        'tanggal_pengadaan' => $validated['tanggal_pengadaan'],
        'gambar' => $gambarPath,
        'detail_kondisi' => $detailKondisi,
    ]);

    // ✅ Kembali ke daftar barang dengan pesan sukses
    return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate!');
}


    /**
     * 🔹 Hapus barang
     */
    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * 🔹 Cetak laporan PDF
     */
    public function laporan()
    {
        $barang = Barang::with(['kategori', 'lokasi', 'sumberDana'])->get();
        $title = 'Laporan Data Barang';
        $date = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('barang.laporan', compact('barang', 'title', 'date'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-barang.pdf');
    }

    /**
     * 🔹 Cetak laporan PDF (versi kedua)
     */
    public function cetakLaporan()
    {
        $barang = Barang::with(['kategori', 'lokasi', 'sumberDana'])->get();
        $title = 'Laporan Data Barang';
        $date = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('barang.laporan-pdf', compact('barang', 'title', 'date'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-barang.pdf');
    }
}
