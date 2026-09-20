<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Isi migration baru
public function up(): void
{
    DB::statement("ALTER TABLE users MODIFY COLUMN role
        ENUM('admin','apoteker','kasir','dokter','manajer')
        NOT NULL DEFAULT 'kasir'");
}

public function down(): void
{
    DB::statement("ALTER TABLE users MODIFY COLUMN role
        ENUM('admin','apoteker','kasir')
        NOT NULL DEFAULT 'kasir'");
}
};
