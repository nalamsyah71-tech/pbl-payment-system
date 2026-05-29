<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_pulsas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('no_kuitansi', 100);
            $table->string('no_sk', 150)->nullable(); // Nomor SK Direktur
            $table->date('tgl_spby');                 // Tanggal SPPBy
            $table->decimal('total_uang', 15, 2)->default(0);
            // Simpan detail peserta dalam JSON: [{id, nama, no_hp, nominal}]
            $table->json('detail_peserta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pulsas');
    }
};