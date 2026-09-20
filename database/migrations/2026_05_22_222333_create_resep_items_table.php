<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_id')->constrained('reseps')->onDelete('cascade');
            $table->unsignedBigInteger('id_varian');
            $table->integer('jumlah');

            // ── Tambahan signa & jadwal ──
            $table->string('satuan')->nullable();
            $table->string('sigma1')->nullable();
            $table->string('sigma2')->nullable();
            $table->unsignedTinyInteger('qty1')->default(0);
            $table->unsignedTinyInteger('pagi')->default(0);
            $table->unsignedTinyInteger('siang')->default(0);
            $table->unsignedTinyInteger('sore')->default(0);
            $table->unsignedTinyInteger('malam')->default(0);
            $table->unsignedTinyInteger('qty2')->default(0);
            $table->string('keterangan_pakai')->nullable();
            // ────────────────────────────

            $table->decimal('harga', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_varian')
                  ->references('id_varian')
                  ->on('varian_obat')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_items');
    }
};
