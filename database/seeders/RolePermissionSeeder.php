<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permission satu per satu jika belum ada
        $permissions = [
            'manage barang',
            'delete barang',
            'view kategori',
            'manage kategori',
            'view lokasi',
            'manage lokasi',
        ];

        foreach ($permissions as $permission) {
            // Cek jika permission sudah ada
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Cek jika role petugas sudah ada, jika belum buat
        if (!Role::where('name', 'petugas')->exists()) {
            $petugasRole = Role::create(['name' => 'petugas']);
        } else {
            $petugasRole = Role::where('name', 'petugas')->first();
        }

        // Cek jika role admin sudah ada, jika belum buat
        if (!Role::where('name', 'admin')->exists()) {
            $adminRole = Role::create(['name' => 'admin']);
        } else {
            $adminRole = Role::where('name', 'admin')->first();
        }

        // Beri permission ke role petugas
        $petugasRole->givePermissionTo([
            'manage barang',
            'view kategori',
            'view lokasi',
        ]);

        // Admin dapat semua permission
        $adminRole->givePermissionTo(Permission::all());
    }
}
