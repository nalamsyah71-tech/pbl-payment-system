<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('nama', 150);
            $table->string('no_hp', 15);
            $table->string('bank', 50)->nullable();
            $table->string('nomor_rekening', 30)->nullable();
            // Hari kehadiran untuk perhitungan uang saku
            $table->integer('hari_kehadiran')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};