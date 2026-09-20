<?php

// database/migrations/xxxx_xx_xx_create_stok_minimum_table.php
// Jalankan: php artisan migrate

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_minimum', function (Blueprint $table) {
            $table->id('id_stok_min');
            $table->unsignedBigInteger('id_varian');
            $table->integer('batas_minimum')->default(10)->comment('Jumlah minimum stok sebelum alert muncul');
            $table->timestamps();

            $table->unique('id_varian'); // satu varian satu batas minimum
            $table->foreign('id_varian')
                  ->references('id_varian')
                  ->on('varian_obat')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_minimum');
    }
};
