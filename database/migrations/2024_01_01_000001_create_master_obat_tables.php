<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_obat', function (Blueprint $table) {
            $table->id('id_jenis');
            $table->string('nama_jenis', 50)->unique();
            $table->timestamps();
        });

        Schema::create('obat', function (Blueprint $table) {
            $table->id('id_obat');
            $table->unsignedBigInteger('id_jenis');
            $table->string('nama_obat', 100);
            $table->timestamps();

            $table->foreign('id_jenis')
                  ->references('id_jenis')
                  ->on('jenis_obat')
                  ->onDelete('restrict');
        });

        Schema::create('varian_obat', function (Blueprint $table) {
            $table->id('id_varian');
            $table->unsignedBigInteger('id_obat');
            $table->string('nama_merek', 100);
            $table->integer('dosis_mg');
            $table->decimal('harga', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_obat')
                  ->references('id_obat')
                  ->on('obat')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('varian_obat');
        Schema::dropIfExists('obat');
        Schema::dropIfExists('jenis_obat');
    }
};
