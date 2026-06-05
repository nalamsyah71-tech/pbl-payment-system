<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran_asuransis', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayaran_asuransis', 'peserta_id')) {
                $table->foreignId('peserta_id')->nullable()->constrained('pesertas')->nullOnDelete()->after('kelas_id');
            }
            if (!Schema::hasColumn('pembayaran_asuransis', 'detail_peserta')) {
                $table->json('detail_peserta')->nullable()->after('total_premi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_asuransis', function (Blueprint $table) {
            $table->dropForeign(['peserta_id']);
            $table->dropColumn(['peserta_id', 'detail_peserta']);
        });
    }
};