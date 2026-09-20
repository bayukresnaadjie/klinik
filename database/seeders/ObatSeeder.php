<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil id_jenis berdasarkan nama
        $jenis = DB::table('jenis_obat')->pluck('id_jenis', 'nama_jenis');

        $obat = [
            // ── Tablet ──────────────────────────────────────
            ['nama_obat' => 'Parasetamol',          'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Ibuprofen',             'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Asam Mefenamat',        'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Amoksisilin',           'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Metformin',             'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Amlodipine',            'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Captopril',             'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Simvastatin',           'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Omeprazole',            'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Antasida',              'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Cetirizine',            'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Loratadine',            'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Dexamethasone',         'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Methylprednisolone',    'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Ciprofloxacin',         'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Cotrimoxazole',         'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Ranitidin',             'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Domperidone',           'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Metoklopramid',         'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Vitamin C',             'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Vitamin B Kompleks',    'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Asam Folat',            'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Kalsium Laktat',        'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Ferro Sulfat',          'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Glibenklamid',          'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Furosemide',            'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Spironolakton',         'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Allopurinol',           'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Natrium Diklofenak',    'nama_jenis' => 'Tablet'],
            ['nama_obat' => 'Tramadol',              'nama_jenis' => 'Tablet'],

            // ── Kapsul ──────────────────────────────────────
            ['nama_obat' => 'Amoksisilin',           'nama_jenis' => 'Kapsul'],
            ['nama_obat' => 'Omeprazole',            'nama_jenis' => 'Kapsul'],
            ['nama_obat' => 'Chloramphenicol',       'nama_jenis' => 'Kapsul'],
            ['nama_obat' => 'Tetrasiklin',           'nama_jenis' => 'Kapsul'],
            ['nama_obat' => 'Vitamin E',             'nama_jenis' => 'Kapsul'],
            ['nama_obat' => 'Minyak Ikan (Omega-3)', 'nama_jenis' => 'Kapsul'],
            ['nama_obat' => 'Itrakonazol',           'nama_jenis' => 'Kapsul'],
            ['nama_obat' => 'Flukonazol',            'nama_jenis' => 'Kapsul'],

            // ── Sirup ───────────────────────────────────────
            ['nama_obat' => 'Parasetamol',           'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Ibuprofen',             'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Amoksisilin',           'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Ambroksol',             'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Bromheksin',            'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Guaifenesin',           'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Salbutamol',            'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Cetirizine',            'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Domperidone',           'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Zinc Sulfat',           'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Oralit',                'nama_jenis' => 'Sirup'],
            ['nama_obat' => 'Antasida',              'nama_jenis' => 'Sirup'],

            // ── Injeksi / Suntik ────────────────────────────
            ['nama_obat' => 'Ketorolac',             'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Dexamethasone',         'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Ondansetron',           'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Ranitidin',             'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Diazepam',              'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Adrenalin (Epinefrin)', 'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Atropin Sulfat',        'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Metoklopramid',         'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Vitamin B12',           'nama_jenis' => 'Injeksi / Suntik'],
            ['nama_obat' => 'Oksitosin',             'nama_jenis' => 'Injeksi / Suntik'],

            // ── Salep / Krim ────────────────────────────────
            ['nama_obat' => 'Hidrokortison',         'nama_jenis' => 'Salep / Krim'],
            ['nama_obat' => 'Betametason',           'nama_jenis' => 'Salep / Krim'],
            ['nama_obat' => 'Mupirosin',             'nama_jenis' => 'Salep / Krim'],
            ['nama_obat' => 'Klotrimazol',           'nama_jenis' => 'Salep / Krim'],
            ['nama_obat' => 'Mikonazol',             'nama_jenis' => 'Salep / Krim'],
            ['nama_obat' => 'Asam Fusidat',          'nama_jenis' => 'Salep / Krim'],
            ['nama_obat' => 'Gentamisin',            'nama_jenis' => 'Salep / Krim'],
            ['nama_obat' => 'Salep 2-4',             'nama_jenis' => 'Salep / Krim'],

            // ── Tetes Mata ──────────────────────────────────
            ['nama_obat' => 'Kloramfenikol Tetes Mata',   'nama_jenis' => 'Tetes Mata'],
            ['nama_obat' => 'Gentamisin Tetes Mata',      'nama_jenis' => 'Tetes Mata'],
            ['nama_obat' => 'Natrium Diklofenak Tetes Mata','nama_jenis'=> 'Tetes Mata'],

            // ── Tetes Telinga ───────────────────────────────
            ['nama_obat' => 'Otolin (Karbogliserin)',     'nama_jenis' => 'Tetes Telinga'],
            ['nama_obat' => 'Kloramfenikol Tetes Telinga','nama_jenis' => 'Tetes Telinga'],

            // ── Serbuk / Puyer ──────────────────────────────
            ['nama_obat' => 'Oralit Serbuk',         'nama_jenis' => 'Serbuk / Puyer'],
            ['nama_obat' => 'Antasida Serbuk',       'nama_jenis' => 'Serbuk / Puyer'],

            // ── Inhaler / Semprot ───────────────────────────
            ['nama_obat' => 'Salbutamol Inhaler',    'nama_jenis' => 'Inhaler / Semprot'],
            ['nama_obat' => 'Budesonide Inhaler',    'nama_jenis' => 'Inhaler / Semprot'],
            ['nama_obat' => 'Ipratropium Inhaler',   'nama_jenis' => 'Inhaler / Semprot'],

            // ── Larutan / Cairan Infus ──────────────────────
            ['nama_obat' => 'NaCl 0.9%',             'nama_jenis' => 'Larutan / Cairan Infus'],
            ['nama_obat' => 'Ringer Laktat',         'nama_jenis' => 'Larutan / Cairan Infus'],
            ['nama_obat' => 'Dextrose 5%',           'nama_jenis' => 'Larutan / Cairan Infus'],
            ['nama_obat' => 'Dextrose 10%',          'nama_jenis' => 'Larutan / Cairan Infus'],
            ['nama_obat' => 'Albumin',               'nama_jenis' => 'Larutan / Cairan Infus'],
        ];

        foreach ($obat as $row) {
            $id_jenis = $jenis[$row['nama_jenis']] ?? null;
            if (!$id_jenis) continue; // skip kalau jenis belum ada di DB

            DB::table('obat')->insertOrIgnore([
                'nama_obat'  => $row['nama_obat'],
                'id_jenis'   => $id_jenis,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
