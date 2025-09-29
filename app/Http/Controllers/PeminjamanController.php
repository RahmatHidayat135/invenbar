<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with('barang')->latest();

        // Fitur search (opsional)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%$search%")
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

    // Cari barang
    $barang = Barang::findOrFail($request->barang_id);

    // Cek stok barang
    if ($request->jumlah > $barang->jumlah) {
        return back()->with('error', 'Jumlah pinjam melebihi stok tersedia!')
                     ->withInput();
    }

    // Simpan data peminjaman
    $peminjaman = Peminjaman::create([
        'barang_id'      => $request->barang_id,
        'nama_peminjam'  => $request->nama_peminjam,
        'jumlah'         => $request->jumlah,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'status'         => 'Dipinjam',
    ]);

    // Kurangi stok barang
    $barang->decrement('jumlah', $request->jumlah);

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

        $peminjaman->update([
            'barang_id'      => $request->barang_id,
            'nama_peminjam'  => $request->nama_peminjam,
            'jumlah'         => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
        ]);

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
        // pakai jumlah, bukan stok
        $peminjaman->barang->increment('jumlah', $peminjaman->jumlah);
    }

    $peminjaman->update([
        'tanggal_kembali' => now(),
        'status' => 'Dikembalikan',
    ]);

    return redirect()->route('peminjaman.index')
        ->with('success', 'Barang berhasil dikembalikan.');
}

}
