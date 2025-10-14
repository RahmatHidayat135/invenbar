<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            KategoriSeeder::class,
            LokasiSeeder::class,
            BarangSeeder::class,
            SumberDanaSeeder::class,
        ]);

        // Admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'), // password custom
        ]);

        // Petugas user
        $petugas = User::create([
            'name' => 'Petugas Inventaris',
            'email' => 'petugas@gmail.com',
            'password' => bcrypt('petugas123'), // password custom
        ]);

        // Assign roles
        $admin->assignRole('admin');
        $petugas->assignRole('petugas');
    }
}
