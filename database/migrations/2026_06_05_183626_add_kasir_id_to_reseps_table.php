<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (!Schema::hasColumn('reseps', 'kasir_id')) {
        Schema::table('reseps', function (Blueprint $table) {
            $table->foreignId('kasir_id')
                  ->nullable()
                  ->after('dokter')
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }
}

    public function down(): void
    {
        Schema::table('reseps', function (Blueprint $table) {
            $table->dropForeign(['kasir_id']);
            $table->dropColumn('kasir_id');
        });
    }
};
