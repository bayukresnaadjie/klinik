<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('approval_requests', function (Blueprint $table) {
        $table->id();
        $table->string('judul')->default('');
        $table->string('deskripsi')->nullable();
        $table->enum('tipe', ['restock','supplier','hapus_batch','tambah_obat'])->default('restock');
        $table->enum('status', ['pending','approved','rejected'])->default('pending');
        $table->json('detail')->nullable();
        $table->unsignedBigInteger('requested_by')->nullable();
        $table->unsignedBigInteger('approved_by')->nullable();
        $table->timestamp('approved_at')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('approval_requests');
}
};
