<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResepSeeder extends Seeder
{
    public function run(): void
    {
        $pasien = ['Budi Santoso','Siti Rahayu','Ahmad Fauzi','Dewi Lestari',
                   'Rini Wulandari','Joko Susilo','Maya Indah','Eko Prasetyo',
                   'Nurul Hidayah','Hendra Wijaya'];

        $varian = DB::table('varian_obat')->pluck('harga','id_varian');

        if ($varian->isEmpty()) {
            $this->command->warn('Varian obat kosong. Jalankan VarianObatSeeder dulu.');
            return;
        }

        $varianIds = $varian->keys()->toArray();
        $counter   = 1;

        // Buat resep dari April–Juni 2026
        for ($bulan = 4; $bulan <= 6; $bulan++) {
            $jumlahResep = rand(15, 25); // 15–25 resep per bulan

            for ($i = 0; $i < $jumlahResep; $i++) {
                $tanggal   = Carbon::create(2026, $bulan, rand(1, 28));
                $status = $bulan < 6 ? 'selesai' : (rand(0, 4) > 0 ? 'selesai' : 'batal');
                $noResep   = 'RES-' . $tanggal->format('Ymd') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

                // Pilih 1–3 varian acak
                $pilihanVarian = array_slice($varianIds, 0);
                shuffle($pilihanVarian);
                $pilihanVarian = array_slice($pilihanVarian, 0, rand(1, 3));

                $total = 0;
                $items = [];
                foreach ($pilihanVarian as $idVarian) {
                    $jumlah   = rand(1, 10);
                    $harga    = $varian[$idVarian] ?? 5000;
                    $subtotal = $jumlah * $harga;
                    $total   += $subtotal;

                   $sigma1Options = ['s1','s2','s3','s4'];
$sigma2Options = ['ac','pc','dc','cum_aqua','hora_somni'];
$ketOptions    = ['diminum_sesudah_makan','diminum_sebelum_makan','habiskan','kocok_dulu'];

$items[] = [
    'id_varian'        => $idVarian,
    'jumlah'           => $jumlah,
    'satuan'           => ['tablet','kapsul','botol','sachet'][rand(0,3)],
    'sigma1'           => $sigma1Options[rand(0,3)],
    'sigma2'           => $sigma2Options[rand(0,4)],
    'qty1'             => rand(1,2),
    'pagi'             => rand(0,1),
    'siang'            => rand(0,1),
    'sore'             => rand(0,1),
    'malam'            => rand(0,1),
    'qty2'             => 0,
    'keterangan_pakai' => $ketOptions[rand(0,3)],
    'harga'            => $harga,
    'subtotal'         => $subtotal,
];
                }

                $resepId = DB::table('reseps')->insertGetId([
                    'no_resep'         => $noResep,
                    'pasien'           => $pasien[array_rand($pasien)],
                    'jenis_pembayaran' => ['umum','bpjs','asuransi'][rand(0,2)],
                    'status'           => $status,
                    'total_harga'      => $status === 'dibatalkan' ? 0 : $total,
                    'created_at'       => $tanggal->toDateTimeString(),
                    'updated_at'       => $tanggal->copy()->addMinutes(rand(5,60))->toDateTimeString(),
                ]);

                foreach ($items as $item) {
                    DB::table('resep_items')->insert(array_merge($item, [
                        'resep_id'   => $resepId,
                        'created_at' => $tanggal->toDateTimeString(),
                        'updated_at' => $tanggal->toDateTimeString(),
                    ]));
                }

                $counter++;
            }
        }

        $this->command->info('ResepSeeder selesai.');
    }
}
