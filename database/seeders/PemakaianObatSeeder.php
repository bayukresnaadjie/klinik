<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemakaianObatSeeder extends Seeder
{
    public function run(): void
    {
        $stokList = DB::table('stok_obat')->get();

        if ($stokList->isEmpty()) {
            $this->command->warn('Stok obat kosong. Jalankan StokObatSeeder dulu.');
            return;
        }

        $keterangan = [
            'Pemakaian harian pasien rawat jalan',
            'Resep dokter umum',
            'Resep dokter spesialis',
            'Pemakaian darurat IGD',
            'Stok habis dipakai pasien rawat inap',
            'Pemberian obat rutin pasien hipertensi',
            'Pemberian obat rutin pasien diabetes',
            'Resep dokter gigi',
            'Pemakaian untuk tindakan medis',
            'Pemberian obat pasien anak',
        ];

        $totalInsert = 0;

        foreach ($stokList as $stok) {

            // Buat 3–8 record pemakaian per stok, tersebar April–Juni
            $jumlahRecord = rand(3, 8);

            for ($i = 0; $i < $jumlahRecord; $i++) {

                // Tanggal acak antara 1 April – 22 Juni 2026
                $tanggal = Carbon::create(2026, 4, 1)
                    ->addDays(rand(0, 82)); // 82 hari = 1 Apr s/d 22 Jun

                // Jumlah pakai acak 1–10, tidak melebihi stok
                $jumlahPakai = rand(1, min(10, max(1, (int)($stok->jumlah / $jumlahRecord))));

                DB::table('pemakaian_obat')->insert([
                    'id_varian'    => $stok->id_varian,
                    'id_stok'      => $stok->id_stok,
                    'jumlah_pakai' => $jumlahPakai,
                    'tanggal_pakai'=> $tanggal->toDateString(),
                    'keterangan'   => $keterangan[array_rand($keterangan)],
                    'created_at'   => $tanggal->toDateTimeString(),
                    'updated_at'   => $tanggal->toDateTimeString(),
                ]);

                $totalInsert++;
            }
        }

        $this->command->info('PemakaianObatSeeder selesai: ' . $totalInsert . ' record pemakaian ditambahkan (Apr–Jun 2026).');
    }
}
