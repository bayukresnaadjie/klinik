<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')
                  ->constrained('supplier', 'id_supplier')
                  ->cascadeOnDelete();
            $table->date('tanggal_kirim');
            $table->date('tanggal_terima')->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->enum('status', ['dikirim', 'diterima', 'dibatalkan'])
                  ->default('dikirim');
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman_supplier');
    }
};
