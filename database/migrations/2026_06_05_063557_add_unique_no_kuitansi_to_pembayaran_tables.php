<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah unique constraint untuk no_kuitansi agar tidak bisa duplikat
        Schema::table('pembayaran_pulsas', function (Blueprint $table) {
            $table->unique('no_kuitansi', 'unique_no_kuitansi_pulsa');
        });

        Schema::table('pembayaran_asuransis', function (Blueprint $table) {
            $table->unique('no_kuitansi', 'unique_no_kuitansi_asuransi');
        });

        Schema::table('pembayaran_uang_sakus', function (Blueprint $table) {
            $table->unique('no_kuitansi', 'unique_no_kuitansi_uang_saku');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_pulsas', function (Blueprint $table) {
            $table->dropUnique('unique_no_kuitansi_pulsa');
        });
        Schema::table('pembayaran_asuransis', function (Blueprint $table) {
            $table->dropUnique('unique_no_kuitansi_asuransi');
        });
        Schema::table('pembayaran_uang_sakus', function (Blueprint $table) {
            $table->dropUnique('unique_no_kuitansi_uang_saku');
        });
    }
};