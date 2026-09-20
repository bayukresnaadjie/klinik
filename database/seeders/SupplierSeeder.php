<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check sementara agar truncate bisa berjalan
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('supplier')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('supplier')->insert([
            [
                'nama'   => 'PT Kimia Farma',
                'kota'   => 'Jakarta',
                'kontak' => '021-5201221',
                'email'  => 'procurement@kimiafarma.co.id',
                'alamat' => 'Jl. Veteran No.9, Gambir, Jakarta Pusat 10110',
                'rating' => 4.8,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Kalbe Farma',
                'kota'   => 'Bekasi',
                'kontak' => '021-4287117',
                'email'  => 'supply@kalbe.co.id',
                'alamat' => 'Jl. Let. Jend. Suprapto Kav.4, Cempaka Putih, Jakarta 10510',
                'rating' => 4.6,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Sanbe Farma',
                'kota'   => 'Bandung',
                'kontak' => '022-6033888',
                'email'  => 'info@sanbe.co.id',
                'alamat' => 'Jl. Industri No.6, Leuwigajah, Cimahi, Bandung 40533',
                'rating' => 4.3,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Dexa Medica',
                'kota'   => 'Palembang',
                'kontak' => '0711-378100',
                'email'  => 'order@dexa-medica.com',
                'alamat' => 'Jl. Jendral Sudirman KM 3.5 Palembang 30128',
                'rating' => 4.5,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Tempo Scan Pacific',
                'kota'   => 'Jakarta',
                'kontak' => '021-4252555',
                'email'  => 'purchase@tempocorp.com',
                'alamat' => 'Tempo Scan Tower, Jl. HR Rasuna Said Kav.3-4, Jakarta 12950',
                'rating' => 4.2,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Phapros',
                'kota'   => 'Semarang',
                'kontak' => '024-3540901',
                'email'  => 'info@phapros.co.id',
                'alamat' => 'Jl. Simongan No.131, Semarang 50148',
                'rating' => 3.9,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Bernofarm',
                'kota'   => 'Tangerang',
                'kontak' => '021-5900990',
                'email'  => 'sales@bernofarm.com',
                'alamat' => 'Jl. Raya Legok Km 6, Tangerang 15820',
                'rating' => 3.7,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Novell Pharmaceutical',
                'kota'   => 'Bogor',
                'kontak' => '0251-8323232',
                'email'  => 'order@novell.co.id',
                'alamat' => 'Jl. Raya Dramaga Km 8, Bogor 16680',
                'rating' => 2.8,
                'aktif'  => false,
            ],
            [
                'nama'   => 'PT Combiphar',
                'kota'   => 'Bandung',
                'kontak' => '022-8601818',
                'email'  => 'info@combiphar.com',
                'alamat' => 'Jl. Soekarno-Hatta No.590, Bandung 40256',
                'rating' => 4.1,
                'aktif'  => true,
            ],
            [
                'nama'   => 'PT Mersi Farma',
                'kota'   => 'Surabaya',
                'kontak' => '031-8480163',
                'email'  => 'procurement@mersifarma.co.id',
                'alamat' => 'Jl. Rungkut Industri Raya No.18, Surabaya 60293',
                'rating' => 2.1,
                'aktif'  => false,
            ],
        ]);
    }
}
