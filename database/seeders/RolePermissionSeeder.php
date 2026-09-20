<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Tambah role dokter dan manajer ke user yang belum ada
        // Sekaligus buat akun default kalau belum ada

        $users = [
            [
                'name'     => 'Administrator',
                'email'    => 'admin@klinik.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'aktif'    => true,
            ],
            [
                'name'     => 'Kasir Klinik',
                'email'    => 'kasir@klinik.com',
                'password' => Hash::make('password'),
                'role'     => 'kasir',
                'aktif'    => true,
            ],
            [
                'name'     => 'Dr. Contoh',
                'email'    => 'dokter@klinik.com',
                'password' => Hash::make('password'),
                'role'     => 'dokter',
                'aktif'    => true,
            ],
            [
                'name'     => 'Manajer Klinik',
                'email'    => 'manajer@klinik.com',
                'password' => Hash::make('password'),
                'role'     => 'manajer',
                'aktif'    => true,
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('✓ Users dengan role lengkap berhasil dibuat.');
    }
}
