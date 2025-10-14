<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class SumberDanaController extends Controller implements HasMiddleware
{
    /**
     * ✅ Middleware Laravel 12
     * - Semua user login bisa lihat (index, show)
     * - Hanya admin yang bisa create, edit, update, delete
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:admin', except: ['index', 'show']),
        ];
    }

    /**
     * ✅ Menampilkan daftar sumber dana
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $sumber_danas = SumberDana::when($search, fn($query, $search) =>
            $query->where('nama_sumber_dana', 'like', '%' . $search . '%')
        )
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('sumber-dana.index', compact('sumber_danas'));
    }

    /**
     * ✅ Form tambah sumber dana baru
     */
    public function create()
    {
        $sumberDana = new SumberDana();
        return view('sumber-dana.create', compact('sumberDana'));
    }

    /**
     * ✅ Simpan sumber dana baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sumber_dana' => 'required|string|max:100|unique:sumber_danas,nama_sumber_dana',
        ]);

        SumberDana::create($validated);

        return redirect()->route('sumber-dana.index')
            ->with('success', 'Sumber Dana baru berhasil ditambahkan.');
    }

    /**
     * ✅ Form edit sumber dana
     */
    public function edit(SumberDana $sumberDana)
    {
        return view('sumber-dana.edit', compact('sumberDana'));
    }

    /**
     * ✅ Update sumber dana
     */
    public function update(Request $request, SumberDana $sumberDana)
    {
        $validated = $request->validate([
            'nama_sumber_dana' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sumber_danas', 'nama_sumber_dana')->ignore($sumberDana->id),
            ],
        ]);

        $sumberDana->update($validated);

        return redirect()->route('sumber-dana.index')
            ->with('success', 'Sumber Dana berhasil diperbarui.');
    }

    /**
     * ✅ Hapus sumber dana (hanya jika tidak terkait barang)
     */
    public function destroy(SumberDana $sumberDana)
    {
        if (method_exists($sumberDana, 'barang') && $sumberDana->barang()->exists()) {
            return redirect()->route('sumber-dana.index')
                ->with('error', 'Sumber Dana tidak dapat dihapus karena masih memiliki barang terkait.');
        }

        $sumberDana->delete();

        return redirect()->route('sumber-dana.index')
            ->with('success', 'Sumber Dana berhasil dihapus.');
    }
}
