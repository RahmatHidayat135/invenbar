<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan sudah install barryvdh/laravel-dompdf



class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with('barang')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('kode_barang', 'like', "%$search%");
            });
        }

        $peminjamans = $query->get();

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'      => 'required|exists:barangs,id',
            'nama_peminjam'  => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return back()->with('error', 'Jumlah pinjam melebihi stok tersedia!')
                         ->withInput();
        }

        Peminjaman::create([
            'barang_id'      => $request->barang_id,
            'nama_peminjam'  => $request->nama_peminjam,
            'jumlah'         => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status'         => 'Dipinjam',
        ]);

        $barang->decrement('stok', $request->jumlah);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $barangs = Barang::all();
        return view('peminjaman.edit', compact('peminjaman', 'barangs'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'barang_id'      => 'required|exists:barangs,id',
            'nama_peminjam'  => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        $peminjaman->update($request->only(['barang_id', 'nama_peminjam', 'jumlah', 'tanggal_pinjam']));

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->barang) {
            $peminjaman->barang->increment('stok', $peminjaman->jumlah);
        }

        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'Dikembalikan',
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Barang berhasil dikembalikan.');
    }

    public function laporan()
{
    $peminjamans = Peminjaman::with('barang')->get();
    $title = "Laporan Data Peminjaman Inventaris";
    $date = now()->translatedFormat('d F Y');

    return view('peminjaman.laporan', compact('peminjamans', 'title', 'date'));
}

    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function cetakLaporan()
{
    $peminjamans = Peminjaman::with('barang')->get();
    $title = "Laporan Data Peminjaman Inventaris";
    $date = now()->translatedFormat('d F Y');

    $pdf = Pdf::loadView('peminjaman.laporan-pdf', compact('peminjamans', 'title', 'date'))
              ->setPaper('A4', 'portrait');

    return $pdf->stream('laporan-peminjaman.pdf');
}

}
