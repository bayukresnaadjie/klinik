<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
    $table->foreignId('resep_id')->constrained('reseps')->cascadeOnDelete();
    $table->decimal('total_tagihan', 12, 2)->default(0);
    $table->decimal('jumlah_bayar',  12, 2)->default(0);
    $table->decimal('kembalian',     12, 2)->default(0);
    $table->enum('metode', ['tunai','transfer','bpjs','asuransi'])->default('tunai');
    $table->foreignId('kasir_id')->nullable()->constrained('users');
    $table->timestamp('paid_at')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
