<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'nik',
        'nama',
        'no_hp',
        'bank',
        'nomor_rekening',
        'hari_kehadiran',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Hitung nominal uang saku berdasarkan hari kehadiran
     * Tarif: Rp 20.000 per hari
     */
    public function getNominalUangSakuAttribute(): int
    {
        return $this->hari_kehadiran * 20000;
    }
}