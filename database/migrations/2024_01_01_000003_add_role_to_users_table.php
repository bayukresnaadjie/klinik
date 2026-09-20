<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom role & status ke tabel users yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'apoteker', 'kasir'])
                  ->default('kasir')
                  ->after('email');

            $table->boolean('aktif')->default(true)->after('role');

            $table->string('no_hp', 20)->nullable()->after('aktif');

            $table->timestamp('last_login_at')->nullable()->after('no_hp');
        });

        // Set user pertama sebagai admin
        \App\Models\User::where('id', 1)->update(['role' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'aktif', 'no_hp', 'last_login_at']);
        });
    }
};
