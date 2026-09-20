<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VarianObatSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil id_obat berdasarkan nama_obat + id_jenis
        $jenis = DB::table('jenis_obat')->pluck('id_jenis', 'nama_jenis');
        $obat  = DB::table('obat')->get()->keyBy(function ($o) {
            return $o->nama_obat . '|' . $o->id_jenis;
        });

        // Helper closure
        $id = function (string $namaObat, string $namaJenis) use ($obat, $jenis): ?int {
            $idJenis = $jenis[$namaJenis] ?? null;
            if (!$idJenis) return null;
            return $obat[$namaObat . '|' . $idJenis]->id_obat ?? null;
        };

        $varian = [

            // ══════════════════════════════════════════
            //  TABLET
            // ══════════════════════════════════════════

            // Parasetamol Tablet
            ['obat' => ['Parasetamol','Tablet'],        'merek' => 'Panadol',           'dosis' => 500,  'harga' => 8000],
            ['obat' => ['Parasetamol','Tablet'],        'merek' => 'Sanmol',            'dosis' => 500,  'harga' => 5000],
            ['obat' => ['Parasetamol','Tablet'],        'merek' => 'Tempra',            'dosis' => 500,  'harga' => 6500],
            ['obat' => ['Parasetamol','Tablet'],        'merek' => 'Biogesic',          'dosis' => 500,  'harga' => 7000],
            ['obat' => ['Parasetamol','Tablet'],        'merek' => 'Paramex',           'dosis' => 500,  'harga' => 4500],

            // Ibuprofen Tablet
            ['obat' => ['Ibuprofen','Tablet'],          'merek' => 'Proris',            'dosis' => 200,  'harga' => 7000],
            ['obat' => ['Ibuprofen','Tablet'],          'merek' => 'Advil',             'dosis' => 400,  'harga' => 12000],
            ['obat' => ['Ibuprofen','Tablet'],          'merek' => 'Brufen',            'dosis' => 400,  'harga' => 10000],
            ['obat' => ['Ibuprofen','Tablet'],          'merek' => 'Ibuprofen Generik', 'dosis' => 400,  'harga' => 3000],

            // Asam Mefenamat
            ['obat' => ['Asam Mefenamat','Tablet'],     'merek' => 'Ponstan',           'dosis' => 500,  'harga' => 15000],
            ['obat' => ['Asam Mefenamat','Tablet'],     'merek' => 'Mefinal',           'dosis' => 500,  'harga' => 12000],
            ['obat' => ['Asam Mefenamat','Tablet'],     'merek' => 'Asam Mefenamat Generik','dosis'=>500,'harga'=> 4000],

            // Amoksisilin Tablet
            ['obat' => ['Amoksisilin','Tablet'],        'merek' => 'Amoxan',            'dosis' => 500,  'harga' => 18000],
            ['obat' => ['Amoksisilin','Tablet'],        'merek' => 'Intermoxil',        'dosis' => 500,  'harga' => 16000],
            ['obat' => ['Amoksisilin','Tablet'],        'merek' => 'Amoksisilin Generik','dosis'=> 500,  'harga' => 5000],

            // Metformin
            ['obat' => ['Metformin','Tablet'],          'merek' => 'Glucophage',        'dosis' => 500,  'harga' => 25000],
            ['obat' => ['Metformin','Tablet'],          'merek' => 'Metformin Generik', 'dosis' => 500,  'harga' => 6000],
            ['obat' => ['Metformin','Tablet'],          'merek' => 'Glucophage XR',     'dosis' => 750,  'harga' => 35000],

            // Amlodipine
            ['obat' => ['Amlodipine','Tablet'],         'merek' => 'Norvask',           'dosis' => 5,    'harga' => 30000],
            ['obat' => ['Amlodipine','Tablet'],         'merek' => 'Tensivask',         'dosis' => 5,    'harga' => 22000],
            ['obat' => ['Amlodipine','Tablet'],         'merek' => 'Amlodipine Generik','dosis' => 5,    'harga' => 5000],
            ['obat' => ['Amlodipine','Tablet'],         'merek' => 'Amlodipine Generik','dosis' => 10,   'harga' => 8000],

            // Captopril
            ['obat' => ['Captopril','Tablet'],          'merek' => 'Capoten',           'dosis' => 25,   'harga' => 20000],
            ['obat' => ['Captopril','Tablet'],          'merek' => 'Captopril Generik', 'dosis' => 12,   'harga' => 3000],
            ['obat' => ['Captopril','Tablet'],          'merek' => 'Captopril Generik', 'dosis' => 25,   'harga' => 4000],

            // Simvastatin
            ['obat' => ['Simvastatin','Tablet'],        'merek' => 'Zocor',             'dosis' => 20,   'harga' => 35000],
            ['obat' => ['Simvastatin','Tablet'],        'merek' => 'Rechol',            'dosis' => 20,   'harga' => 25000],
            ['obat' => ['Simvastatin','Tablet'],        'merek' => 'Simvastatin Generik','dosis'=> 20,   'harga' => 6000],

            // Omeprazole Tablet
            ['obat' => ['Omeprazole','Tablet'],         'merek' => 'Losec',             'dosis' => 20,   'harga' => 30000],
            ['obat' => ['Omeprazole','Tablet'],         'merek' => 'Omeprazole Generik','dosis' => 20,   'harga' => 5000],

            // Cetirizine
            ['obat' => ['Cetirizine','Tablet'],         'merek' => 'Zyrtec',            'dosis' => 10,   'harga' => 25000],
            ['obat' => ['Cetirizine','Tablet'],         'merek' => 'Ryzen',             'dosis' => 10,   'harga' => 18000],
            ['obat' => ['Cetirizine','Tablet'],         'merek' => 'Cetirizine Generik','dosis' => 10,   'harga' => 4000],

            // Loratadine
            ['obat' => ['Loratadine','Tablet'],         'merek' => 'Claritin',          'dosis' => 10,   'harga' => 22000],
            ['obat' => ['Loratadine','Tablet'],         'merek' => 'Loratadine Generik','dosis' => 10,   'harga' => 4000],

            // Dexamethasone Tablet
            ['obat' => ['Dexamethasone','Tablet'],      'merek' => 'Dexamethasone Generik','dosis'=> 500,'harga'=> 2000],

            // Ciprofloxacin
            ['obat' => ['Ciprofloxacin','Tablet'],      'merek' => 'Ciproxin',          'dosis' => 500,  'harga' => 35000],
            ['obat' => ['Ciprofloxacin','Tablet'],      'merek' => 'Baquinor',          'dosis' => 500,  'harga' => 28000],
            ['obat' => ['Ciprofloxacin','Tablet'],      'merek' => 'Ciprofloxacin Generik','dosis'=>500, 'harga' => 7000],

            // Ranitidin Tablet
            ['obat' => ['Ranitidin','Tablet'],          'merek' => 'Zantac',            'dosis' => 150,  'harga' => 20000],
            ['obat' => ['Ranitidin','Tablet'],          'merek' => 'Ranitidin Generik', 'dosis' => 150,  'harga' => 3000],

            // Domperidone Tablet
            ['obat' => ['Domperidone','Tablet'],        'merek' => 'Motilium',          'dosis' => 10,   'harga' => 18000],
            ['obat' => ['Domperidone','Tablet'],        'merek' => 'Vometa',            'dosis' => 10,   'harga' => 12000],
            ['obat' => ['Domperidone','Tablet'],        'merek' => 'Domperidone Generik','dosis'=> 10,   'harga' => 3500],

            // Vitamin C
            ['obat' => ['Vitamin C','Tablet'],          'merek' => 'Redoxon',           'dosis' => 500,  'harga' => 15000],
            ['obat' => ['Vitamin C','Tablet'],          'merek' => 'Vicee',             'dosis' => 500,  'harga' => 12000],
            ['obat' => ['Vitamin C','Tablet'],          'merek' => 'Vitamin C Generik', 'dosis' => 50,   'harga' => 1500],

            // Allopurinol
            ['obat' => ['Allopurinol','Tablet'],        'merek' => 'Zyloric',           'dosis' => 100,  'harga' => 20000],
            ['obat' => ['Allopurinol','Tablet'],        'merek' => 'Allopurinol Generik','dosis'=> 100,  'harga' => 3000],
            ['obat' => ['Allopurinol','Tablet'],        'merek' => 'Allopurinol Generik','dosis'=> 300,  'harga' => 5000],

            // Furosemide
            ['obat' => ['Furosemide','Tablet'],         'merek' => 'Lasix',             'dosis' => 40,   'harga' => 18000],
            ['obat' => ['Furosemide','Tablet'],         'merek' => 'Furosemide Generik','dosis' => 40,   'harga' => 2500],

            // Natrium Diklofenak
            ['obat' => ['Natrium Diklofenak','Tablet'], 'merek' => 'Voltaren',          'dosis' => 50,   'harga' => 22000],
            ['obat' => ['Natrium Diklofenak','Tablet'], 'merek' => 'Cataflam',          'dosis' => 50,   'harga' => 25000],
            ['obat' => ['Natrium Diklofenak','Tablet'], 'merek' => 'Diklofenak Generik','dosis' => 50,   'harga' => 4000],

            // ══════════════════════════════════════════
            //  KAPSUL
            // ══════════════════════════════════════════

            ['obat' => ['Amoksisilin','Kapsul'],        'merek' => 'Amoxan',            'dosis' => 500,  'harga' => 20000],
            ['obat' => ['Amoksisilin','Kapsul'],        'merek' => 'Amoksisilin Generik','dosis'=> 500,  'harga' => 6000],
            ['obat' => ['Omeprazole','Kapsul'],         'merek' => 'Losec',             'dosis' => 20,   'harga' => 32000],
            ['obat' => ['Omeprazole','Kapsul'],         'merek' => 'Omeprazole Generik','dosis' => 20,   'harga' => 6000],
            ['obat' => ['Chloramphenicol','Kapsul'],    'merek' => 'Kloramfenikol Generik','dosis'=>250, 'harga' => 5000],
            ['obat' => ['Itrakonazol','Kapsul'],        'merek' => 'Sporanox',          'dosis' => 100,  'harga' => 45000],
            ['obat' => ['Itrakonazol','Kapsul'],        'merek' => 'Itrakonazol Generik','dosis'=> 100,  'harga' => 15000],
            ['obat' => ['Flukonazol','Kapsul'],         'merek' => 'Diflucan',          'dosis' => 150,  'harga' => 50000],
            ['obat' => ['Flukonazol','Kapsul'],         'merek' => 'Flukonazol Generik','dosis' => 150,  'harga' => 18000],
            ['obat' => ['Vitamin E','Kapsul'],          'merek' => 'Natur-E',           'dosis' => 100,  'harga' => 20000],
            ['obat' => ['Vitamin E','Kapsul'],          'merek' => 'Evion',             'dosis' => 400,  'harga' => 25000],
            ['obat' => ['Minyak Ikan (Omega-3)','Kapsul'],'merek'=> 'Scott\'s',         'dosis' => 1000, 'harga' => 35000],
            ['obat' => ['Minyak Ikan (Omega-3)','Kapsul'],'merek'=> 'Omega-3 Generik',  'dosis' => 1000, 'harga' => 20000],

            // ══════════════════════════════════════════
            //  SIRUP
            // ══════════════════════════════════════════

            ['obat' => ['Parasetamol','Sirup'],         'merek' => 'Panadol Syrup',     'dosis' => 120,  'harga' => 22000],
            ['obat' => ['Parasetamol','Sirup'],         'merek' => 'Sanmol Syrup',      'dosis' => 120,  'harga' => 18000],
            ['obat' => ['Parasetamol','Sirup'],         'merek' => 'Tempra Syrup',      'dosis' => 160,  'harga' => 20000],
            ['obat' => ['Ibuprofen','Sirup'],           'merek' => 'Proris Syrup',      'dosis' => 100,  'harga' => 25000],
            ['obat' => ['Ibuprofen','Sirup'],           'merek' => 'Ibuprofen Generik Syrup','dosis'=>100,'harga'=> 10000],
            ['obat' => ['Amoksisilin','Sirup'],         'merek' => 'Amoxan Syrup',      'dosis' => 125,  'harga' => 28000],
            ['obat' => ['Amoksisilin','Sirup'],         'merek' => 'Amoksisilin Generik Syrup','dosis'=>125,'harga'=>12000],
            ['obat' => ['Ambroksol','Sirup'],           'merek' => 'Mucopect',          'dosis' => 15,   'harga' => 22000],
            ['obat' => ['Ambroksol','Sirup'],           'merek' => 'Ambril',            'dosis' => 15,   'harga' => 18000],
            ['obat' => ['Guaifenesin','Sirup'],         'merek' => 'OBH Combi',         'dosis' => 100,  'harga' => 20000],
            ['obat' => ['Guaifenesin','Sirup'],         'merek' => 'Bisolvon',          'dosis' => 100,  'harga' => 22000],
            ['obat' => ['Salbutamol','Sirup'],          'merek' => 'Ventolin Syrup',    'dosis' => 2,    'harga' => 25000],
            ['obat' => ['Salbutamol','Sirup'],          'merek' => 'Salbutamol Generik','dosis' => 2,    'harga' => 8000],
            ['obat' => ['Cetirizine','Sirup'],          'merek' => 'Zyrtec Syrup',      'dosis' => 5,    'harga' => 28000],
            ['obat' => ['Domperidone','Sirup'],         'merek' => 'Motilium Syrup',    'dosis' => 5,    'harga' => 22000],
            ['obat' => ['Domperidone','Sirup'],         'merek' => 'Vometa Syrup',      'dosis' => 5,    'harga' => 15000],
            ['obat' => ['Zinc Sulfat','Sirup'],         'merek' => 'Zinkid',            'dosis' => 10,   'harga' => 18000],
            ['obat' => ['Zinc Sulfat','Sirup'],         'merek' => 'Orezinc',           'dosis' => 10,   'harga' => 15000],
            ['obat' => ['Oralit','Sirup'],              'merek' => 'Oralit 200',        'dosis' => null,  'harga' => 5000],

            // ══════════════════════════════════════════
            //  INJEKSI / SUNTIK
            // ══════════════════════════════════════════

            ['obat' => ['Ketorolac','Injeksi / Suntik'],        'merek' => 'Toradol',           'dosis' => 30,  'harga' => 25000],
            ['obat' => ['Ketorolac','Injeksi / Suntik'],        'merek' => 'Ketorolac Generik', 'dosis' => 30,  'harga' => 10000],
            ['obat' => ['Dexamethasone','Injeksi / Suntik'],    'merek' => 'Dexamethasone Generik','dosis'=> 5, 'harga' => 8000],
            ['obat' => ['Ondansetron','Injeksi / Suntik'],      'merek' => 'Zofran',            'dosis' => 4,   'harga' => 35000],
            ['obat' => ['Ondansetron','Injeksi / Suntik'],      'merek' => 'Ondansetron Generik','dosis'=> 4,   'harga' => 12000],
            ['obat' => ['Ranitidin','Injeksi / Suntik'],        'merek' => 'Ranitidin Generik', 'dosis' => 25,  'harga' => 8000],
            ['obat' => ['Adrenalin (Epinefrin)','Injeksi / Suntik'],'merek'=>'Epinefrin Generik','dosis'=> 1,   'harga' => 15000],
            ['obat' => ['Metoklopramid','Injeksi / Suntik'],    'merek' => 'Primperan Injeksi', 'dosis' => 10,  'harga' => 12000],
            ['obat' => ['Vitamin B12','Injeksi / Suntik'],      'merek' => 'Neurobion Injeksi', 'dosis' => null,'harga' => 25000],
            ['obat' => ['Oksitosin','Injeksi / Suntik'],        'merek' => 'Oksitosin Generik', 'dosis' => 10,  'harga' => 18000],

            // ══════════════════════════════════════════
            //  SALEP / KRIM
            // ══════════════════════════════════════════

            ['obat' => ['Hidrokortison','Salep / Krim'],        'merek' => 'Hidrokortison Generik','dosis'=>null,'harga'=>8000],
            ['obat' => ['Betametason','Salep / Krim'],          'merek' => 'Celestoderm',       'dosis' => null,'harga' => 20000],
            ['obat' => ['Betametason','Salep / Krim'],          'merek' => 'Betametason Generik','dosis'=> null,'harga' => 7000],
            ['obat' => ['Mupirosin','Salep / Krim'],            'merek' => 'Bactroban',         'dosis' => null,'harga' => 35000],
            ['obat' => ['Klotrimazol','Salep / Krim'],          'merek' => 'Canesten',          'dosis' => null,'harga' => 22000],
            ['obat' => ['Klotrimazol','Salep / Krim'],          'merek' => 'Klotrimazol Generik','dosis'=>null, 'harga' => 8000],
            ['obat' => ['Mikonazol','Salep / Krim'],            'merek' => 'Daktarin',          'dosis' => null,'harga' => 20000],
            ['obat' => ['Gentamisin','Salep / Krim'],           'merek' => 'Garamycin',         'dosis' => null,'harga' => 18000],
            ['obat' => ['Gentamisin','Salep / Krim'],           'merek' => 'Gentamisin Generik','dosis' => null,'harga' => 6000],
            ['obat' => ['Salep 2-4','Salep / Krim'],            'merek' => 'Salep 2-4 Generik', 'dosis' => null,'harga' => 5000],

            // ══════════════════════════════════════════
            //  TETES MATA
            // ══════════════════════════════════════════

            ['obat' => ['Kloramfenikol Tetes Mata','Tetes Mata'],     'merek' => 'Erlamycetin',      'dosis' => null,'harga' => 12000],
            ['obat' => ['Kloramfenikol Tetes Mata','Tetes Mata'],     'merek' => 'Kloramfenikol Generik','dosis'=>null,'harga'=> 6000],
            ['obat' => ['Gentamisin Tetes Mata','Tetes Mata'],        'merek' => 'Gentamicin Eye Drop','dosis'=>null,'harga'=> 15000],
            ['obat' => ['Natrium Diklofenak Tetes Mata','Tetes Mata'],'merek' => 'Voltaren Eye Drop', 'dosis'=>null,'harga'=> 28000],

            // ══════════════════════════════════════════
            //  TETES TELINGA
            // ══════════════════════════════════════════

            ['obat' => ['Otolin (Karbogliserin)','Tetes Telinga'],    'merek' => 'Otolin',           'dosis' => null,'harga' => 15000],
            ['obat' => ['Kloramfenikol Tetes Telinga','Tetes Telinga'],'merek'=> 'Kloramfenikol Ear Drop','dosis'=>null,'harga'=>10000],

            // ══════════════════════════════════════════
            //  INHALER / SEMPROT
            // ══════════════════════════════════════════

            ['obat' => ['Salbutamol Inhaler','Inhaler / Semprot'],    'merek' => 'Ventolin Inhaler', 'dosis' => 100, 'harga' => 45000],
            ['obat' => ['Salbutamol Inhaler','Inhaler / Semprot'],    'merek' => 'Asmasorin',        'dosis' => 100, 'harga' => 38000],
            ['obat' => ['Budesonide Inhaler','Inhaler / Semprot'],    'merek' => 'Pulmicort',        'dosis' => 200, 'harga' => 85000],
            ['obat' => ['Ipratropium Inhaler','Inhaler / Semprot'],   'merek' => 'Atrovent',         'dosis' => 20,  'harga' => 75000],

            // ══════════════════════════════════════════
            //  LARUTAN / CAIRAN INFUS
            // ══════════════════════════════════════════

            ['obat' => ['NaCl 0.9%','Larutan / Cairan Infus'],        'merek' => 'NaCl 0.9% Otsuka',  'dosis' => null,'harga' => 22000],
            ['obat' => ['NaCl 0.9%','Larutan / Cairan Infus'],        'merek' => 'NaCl 0.9% Widatra', 'dosis' => null,'harga' => 20000],
            ['obat' => ['Ringer Laktat','Larutan / Cairan Infus'],     'merek' => 'RL Otsuka',         'dosis' => null,'harga' => 22000],
            ['obat' => ['Ringer Laktat','Larutan / Cairan Infus'],     'merek' => 'RL Widatra',        'dosis' => null,'harga' => 20000],
            ['obat' => ['Dextrose 5%','Larutan / Cairan Infus'],       'merek' => 'D5% Otsuka',        'dosis' => null,'harga' => 22000],
            ['obat' => ['Dextrose 10%','Larutan / Cairan Infus'],      'merek' => 'D10% Otsuka',       'dosis' => null,'harga' => 28000],
            ['obat' => ['Albumin','Larutan / Cairan Infus'],           'merek' => 'Albumin 20%',       'dosis' => null,'harga' => 350000],

            // ══════════════════════════════════════════
            //  SERBUK / PUYER
            // ══════════════════════════════════════════

            ['obat' => ['Oralit Serbuk','Serbuk / Puyer'],            'merek' => 'Oralit Generik',    'dosis' => null,'harga' => 3000],
            ['obat' => ['Antasida Serbuk','Serbuk / Puyer'],          'merek' => 'Antasida Doen',     'dosis' => null,'harga' => 4000],
        ];

        foreach ($varian as $v) {
            [$namaObat, $namaJenis] = $v['obat'];
            $idObat = $id($namaObat, $namaJenis);

            if (!$idObat) continue; // skip jika obat belum ada

            DB::table('varian_obat')->insertOrIgnore([
                'id_obat'    => $idObat,
                'nama_merek' => $v['merek'],
                'dosis_mg'   => $v['dosis'],
                'harga'      => $v['harga'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
