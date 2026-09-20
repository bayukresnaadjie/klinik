<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harga_varian', function (Blueprint $table) {
            $table->id('id_harga');
            $table->unsignedBigInteger('id_varian');
            $table->decimal('harga', 12, 2);
            $table->date('berlaku_mulai');   // tanggal harga mulai berlaku
            $table->date('berlaku_sampai')->nullable(); // null = masih aktif
            $table->timestamps();

            $table->foreign('id_varian')
                  ->references('id_varian')
                  ->on('varian_obat')
                  ->onDelete('cascade');

            // Pastikan hanya ada 1 harga aktif per varian
            $table->unique(['id_varian', 'berlaku_mulai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harga_varian');
    }
};
