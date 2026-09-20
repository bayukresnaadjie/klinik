<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_obat', function (Blueprint $table) {
            $table->id('id_stok');
            $table->unsignedBigInteger('id_varian');
            $table->string('no_batch', 50)->nullable();
            $table->integer('jumlah')->default(0);
            $table->date('tanggal_masuk');
            $table->date('tanggal_kadaluarsa');
            $table->timestamps();

            $table->foreign('id_varian')
                  ->references('id_varian')
                  ->on('varian_obat')
                  ->onDelete('restrict');

            $table->index(['id_varian', 'tanggal_kadaluarsa']);
            $table->index('tanggal_kadaluarsa');
        });

        Schema::create('pemakaian_obat', function (Blueprint $table) {
            $table->id('id_pakai');
            $table->unsignedBigInteger('id_varian');
            $table->unsignedBigInteger('id_stok');
            $table->integer('jumlah_pakai');
            $table->date('tanggal_pakai');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_varian')
                  ->references('id_varian')
                  ->on('varian_obat')
                  ->onDelete('restrict');

            $table->foreign('id_stok')
                  ->references('id_stok')
                  ->on('stok_obat')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemakaian_obat');
        Schema::dropIfExists('stok_obat');
    }
};
