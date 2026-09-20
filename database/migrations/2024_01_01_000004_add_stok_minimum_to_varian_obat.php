<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('varian_obat', function (Blueprint $table) {
            // Stok minimum yang harus selalu tersedia
            $table->integer('stok_minimum')->default(0)->after('harga');

            // Aktifkan/matikan alert stok minimum per varian
            $table->boolean('alert_minimum')->default(false)->after('stok_minimum');
        });
    }

    public function down(): void
    {
        Schema::table('varian_obat', function (Blueprint $table) {
            $table->dropColumn(['stok_minimum', 'alert_minimum']);
        });
    }
};
