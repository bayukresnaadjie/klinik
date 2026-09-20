<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokObatSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua varian yang ada
        $varian = DB::table('varian_obat')->get();

        if ($varian->isEmpty()) {
            $this->command->warn('Varian obat kosong. Jalankan VarianObatSeeder dulu.');
            return;
        }

        foreach ($varian as $v) {
            // Setiap varian dibuat 2 batch stok
            // Batch 1 — stok lama, kadaluarsa lebih dekat
            DB::table('stok_obat')->insertOrIgnore([
                'id_varian'          => $v->id_varian,
                'no_batch'           => 'BCH-' . str_pad($v->id_varian, 4, '0', STR_PAD_LEFT) . '-A',
                'jumlah'             => rand(50, 150),
                'tanggal_masuk'      => Carbon::now()->subMonths(rand(3, 6))->toDateString(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(rand(12, 18))->toDateString(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Batch 2 — stok baru, kadaluarsa lebih jauh
            DB::table('stok_obat')->insertOrIgnore([
                'id_varian'          => $v->id_varian,
                'no_batch'           => 'BCH-' . str_pad($v->id_varian, 4, '0', STR_PAD_LEFT) . '-B',
                'jumlah'             => rand(20, 100),
                'tanggal_masuk'      => Carbon::now()->subMonths(rand(1, 2))->toDateString(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(rand(18, 36))->toDateString(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        $this->command->info('StokObatSeeder selesai: ' . ($varian->count() * 2) . ' batch stok ditambahkan.');
    }
}
