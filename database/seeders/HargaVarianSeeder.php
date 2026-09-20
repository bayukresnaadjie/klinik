<?php
// database/seeders/HargaVarianSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HargaVarianSeeder extends Seeder
{
    public function run(): void
    {
        $varian = DB::table('varian_obat')->get();

        foreach ($varian as $v) {
            DB::table('harga_varian')->insertOrIgnore([
                'id_varian'      => $v->id_varian,
                'harga'          => $v->harga,         // ambil harga existing
                'berlaku_mulai'  => now()->startOfMonth()->toDateString(),
                'berlaku_sampai' => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
