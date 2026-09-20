<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('approval_requests', function (Blueprint $table) {
            $table->string('reject_reason', 255)
                  ->nullable()
                  ->after('approved_at')  // ← masuk setelah approved_at
                  ->comment('Alasan penolakan oleh Manager');
        });
    }

    public function down(): void
    {
        Schema::table('approval_requests', function (Blueprint $table) {
            $table->dropColumn('reject_reason');
        });
    }
};
