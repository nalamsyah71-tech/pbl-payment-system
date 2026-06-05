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
    Schema::table('pembayaran_asuransis', function (Blueprint $table) {
        if (!Schema::hasColumn('pembayaran_asuransis', 'peserta_id')) {
            $table->foreignId('peserta_id')->nullable()->after('kelas_id')->constrained('pesertas')->onDelete('set null');
        }
        if (!Schema::hasColumn('pembayaran_asuransis', 'detail_peserta')) {
            $table->json('detail_peserta')->nullable()->after('total_premi');
        }
    });
    }

    public function down()
    {
        Schema::table('pembayaran_asuransis', function (Blueprint $table) {
            $table->dropForeign(['peserta_id']);
            $table->dropColumn(['peserta_id', 'detail_peserta']);
        });
    }


};
