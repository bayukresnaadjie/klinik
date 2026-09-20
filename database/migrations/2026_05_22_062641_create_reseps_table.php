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
        Schema::create('reseps', function (Blueprint $table) {
             $table->id();
        $table->string('no_resep')->unique();
        $table->string('pasien')->nullable();        // nama pasien
        $table->string('dokter')->nullable();        // nama dokter
        $table->enum('status', ['menunggu', 'tunda', 'selesai', 'batal'])->default('menunggu');
        $table->decimal('total_harga', 12, 2)->default(0);
        $table->text('catatan')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
