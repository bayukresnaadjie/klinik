<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── User default ──────────────────────────────
        User::factory()->create([
            'name'  => 'Admin',
            'email' => 'admin@klinik.com',
        ]);

        // ── Master data farmasi ───────────────────────
        $this->call([
            JenisObatSeeder::class,
    ObatSeeder::class,
    VarianObatSeeder::class,
    HargaVarianSeeder::class,
    StokObatSeeder::class,
    PemakaianObatSeeder::class,
        ]);
    }
}
