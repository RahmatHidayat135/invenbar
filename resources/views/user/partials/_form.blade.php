@csrf
<div class="mb-3">
    <x-form-input label="Nama Lengkap" name="name" :value="$user->name" />
</div>

<div class="mb-3">
    <x-form-input label="Email" name="email" :value="$user->email" type="email" />
</div>

<div class="mb-3">
    <x-form-input label="Password" name="password" type="password" />
</div>

<div class="mb-3">
    <x-form-input label="Konfirmasi Password" name="password_confirmation" type="password" />
</div>

{{-- Tambah pilihan role --}}
<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select name="role" class="form-control" required>
        <option value="petugas" {{ old('role', $user->roles->first()->name ?? '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
        <option value="admin" {{ old('role', $user->roles->first()->name ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
</div>

<div class="mb-4">
    <x-primary-button>
        {{ isset($user->id) ? __('Update') : __('Simpan') }}
    </x-primary-button>

    <x-secondary-button :href="route('user.index')">
        {{ __('Kembali') }}
    </x-secondary-button>
</div>
