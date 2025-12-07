<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MstAnggotaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mst_anggota')->insertOrIgnore([
            [
                'ID_Anggota' => 1,
                'nim' => 'G.211.24.0083',
                'nama' => 'Ivan Surya Buwana',
                'progdi' => 'TI',
            ],
            [
                'ID_Anggota' => 2,
                'nim' => 'G.211.24.0084',
                'nama' => 'Dewi Lestari',
                'progdi' => 'TI',
            ],
            [
                'ID_Anggota' => 3,
                'nim' => 'G.211.24.0085',
                'nama' => 'Budi Santoso',
                'progdi' => 'SI',
            ],
            [
                'ID_Anggota' => 4,
                'nim' => 'G.211.24.0086',
                'nama' => 'Siti Aminah',
                'progdi' => 'SI',
            ],
            [
                'ID_Anggota' => 6,
                'nim' => 'G.211.24.0087',
                'nama' => 'Rini Kusuma',
                'progdi' => 'DKV',
            ],
            [
                'ID_Anggota' => 7,
                'nim' => 'G.211.24.0088',
                'nama' => 'Yoga Pratama',
                'progdi' => 'MM',
            ],
            [
                'ID_Anggota' => 8,
                'nim' => 'G.211.24.0089',
                'nama' => 'Layla Rahmawati',
                'progdi' => 'AK',
            ],
        ]);
    }
}
