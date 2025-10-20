<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SumberDanaSeeder extends Seeder
{
    public function run(): void
    {
        $sumberDanas = [
            ['nama_sumber_dana' => 'Pemerintah'],
            ['nama_sumber_dana' => 'BOS Sekolah'],
            ['nama_sumber_dana' => 'Donasi'],
        ];

        foreach ($sumberDanas as $data) {
            DB::table('sumber_danas')->updateOrInsert(
                ['nama_sumber_dana' => $data['nama_sumber_dana']],
                $data
            );
        }
    }
}
