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
    Schema::create('supplier', function (Blueprint $table) {
        $table->id('id_supplier');
        $table->string('nama', 100);
        $table->string('kota', 100)->nullable();
        $table->string('alamat')->nullable();
        $table->string('kontak', 20)->nullable();
        $table->string('email')->nullable();
        $table->decimal('rating', 3, 1)->default(0);
        $table->boolean('aktif')->default(true);
        $table->timestamps();
    });

    // Tambah kolom id_supplier ke stok_obat
    Schema::table('stok_obat', function (Blueprint $table) {
        $table->unsignedBigInteger('id_supplier')->nullable()->after('id_stok');
        $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('stok_obat', function (Blueprint $table) {
        $table->dropForeign(['id_supplier']);
        $table->dropColumn('id_supplier');
    });
    Schema::dropIfExists('supplier');
}
};
