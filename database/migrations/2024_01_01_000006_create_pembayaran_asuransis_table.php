<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_asuransis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('no_kuitansi', 100);
            $table->string('no_sk', 150)->nullable();
            $table->date('tgl_spby');
            $table->integer('jumlah_peserta')->default(0);
            // Premi BPJS Ketenagakerjaan: Rp 8.400 per peserta per bulan
            $table->decimal('total_premi', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_asuransis');
    }
};