<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisObatSeeder extends Seeder
{
    public function run(): void
    {
        $jenisObat = [
            'Kapsul',
            'Sirup',
            'Tablet',
            'Injeksi / Suntik',
            'Salep / Krim',
            'Tetes Mata',
            'Tetes Telinga',
            'Serbuk / Puyer',
            'Suppositoria',
            'Inhaler / Semprot',
            'Patch / Plester',
            'Larutan / Cairan Infus',
        ];

        foreach ($jenisObat as $nama) {
            DB::table('jenis_obat')->insertOrIgnore([
                'nama_jenis' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
