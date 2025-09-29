<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'role:admin', // hanya admin yang bisa akses
        ];
    }
    public function index(Request $request)
    {
        $search = $request->search ?? null;

        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->oldest()
            ->paginate()
            ->withQueryString();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $user = new User();

    return view('user.create', compact('user'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:50|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $validated['password'] = bcrypt($validated['password']);

    $user = User::create($validated);

    $user->assignRole('petugas');

    return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
}


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        abort (404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return  view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:50|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role' => 'required|string',
    ]);

    if ($request->password) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);

    // Update role
    $user->syncRoles([$validated['role']]);

    return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
{
    // Cek kalau user yang sedang login coba hapus dirinya sendiri
    if ($user->id === Auth::id()) {
        return redirect()->route('user.index')
            ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    }

    // Hapus user
    $user->delete();

    return redirect()->route('user.index')
        ->with('success', 'Pengguna berhasil dihapus.');
}

}
