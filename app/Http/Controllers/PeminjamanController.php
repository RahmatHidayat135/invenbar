<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with('barang')->orderBy('id', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%$search%")
                  ->orWhere('kode_barang', 'like', "%$search%");
            })
            ->orWhere('nama_peminjam', 'like', "%$search%");
        }

        // ✅ ganti get() → paginate()
        $peminjamans = $query->paginate(10);

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

        if ($request->jumlah > $barang->jumlah) {
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

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Cek apakah sudah dikembalikan sebelumnya
        if ($peminjaman->status === 'Dikembalikan') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Barang sudah dikembalikan sebelumnya.');
        }

        // Update status & tanggal kembali
        $peminjaman->status = 'Dikembalikan';
        $peminjaman->tanggal_kembali = Carbon::now()->toDateString();
        $peminjaman->save();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Barang berhasil dikembalikan.');
    }

    public function laporan()
    {
        $peminjamans = Peminjaman::with('barang')
            ->orderBy('id', 'asc')
            ->get();

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
        $peminjamans = Peminjaman::with('barang')
            ->orderBy('id', 'asc')
            ->get();

        $title = "Laporan Data Peminjaman Inventaris";
        $date = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('peminjaman.laporan-pdf', compact('peminjamans', 'title', 'date'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-peminjaman.pdf');
    }
}
