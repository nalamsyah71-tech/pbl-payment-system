<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pembayaran_pulsas', function (Blueprint $table) {
            $table->foreignId('peserta_id')->nullable()->after('kelas_id')->constrained('pesertas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pembayaran_pulsas', function (Blueprint $table) {
            $table->dropForeign(['peserta_id']);
            $table->dropColumn('peserta_id');
        });
    }
};