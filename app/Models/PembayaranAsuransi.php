<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranAsuransi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'peserta_id',  
        'no_kuitansi',
        'no_sk',
        'tgl_spby',
        'jumlah_peserta',
        'total_premi',
        'detail_peserta'
    ];

    protected $casts = [
        'tgl_spby'    => 'date',
        'total_premi' => 'decimal:2',
        'detail_peserta' => 'array'
    ];

    // Konstanta premi BPJS Ketenagakerjaan per peserta
    const PREMI_PER_PESERTA = 8400;

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function peserta()  // ← TAMBAHKAN RELASI
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}