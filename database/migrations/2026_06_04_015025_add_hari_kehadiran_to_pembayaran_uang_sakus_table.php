<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pembayaran_uang_sakus', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayaran_uang_sakus', 'hari_kehadiran')) {
                $table->integer('hari_kehadiran')->nullable()->after('total_uang');
            }
            if (!Schema::hasColumn('pembayaran_uang_sakus', 'peserta_id')) {
                $table->foreignId('peserta_id')->nullable()->after('kelas_id')->constrained('pesertas')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('pembayaran_uang_sakus', function (Blueprint $table) {
            $table->dropColumn('hari_kehadiran');
            $table->dropForeign(['peserta_id']);
            $table->dropColumn('peserta_id');
        });
    }
};