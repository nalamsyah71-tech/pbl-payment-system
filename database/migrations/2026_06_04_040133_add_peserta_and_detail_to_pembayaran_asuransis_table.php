<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran_asuransis', function (Blueprint $table) {
            // Tambah kolom peserta_id
            if (!Schema::hasColumn('pembayaran_asuransis', 'peserta_id')) {
                $table->foreignId('peserta_id')->nullable()->after('kelas_id')->constrained('pesertas')->onDelete('set null');
            }
            
            // Tambah kolom detail_peserta (JSON)
            if (!Schema::hasColumn('pembayaran_asuransis', 'detail_peserta')) {
                $table->json('detail_peserta')->nullable()->after('total_premi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_asuransis', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['peserta_id']);
            
            // Hapus kolom
            $table->dropColumn(['peserta_id', 'detail_peserta']);
        });
    }
};