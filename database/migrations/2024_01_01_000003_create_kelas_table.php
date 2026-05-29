<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihans')->onDelete('cascade');
            $table->string('nama_kelas', 150);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('hari_efektif')->default(0);
            // MAK (Mata Anggaran Kegiatan) - nomor anggaran per jenis pembayaran
            $table->string('mak_pulsa', 50)->nullable();
            $table->string('mak_asuransi', 50)->nullable();
            $table->string('mak_uang_saku', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};