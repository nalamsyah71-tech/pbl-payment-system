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
        'no_kuitansi',
        'no_sk',
        'tgl_spby',
        'jumlah_peserta',
        'total_premi',
    ];

    protected $casts = [
        'tgl_spby'    => 'date',
        'total_premi' => 'decimal:2',
    ];

    // Konstanta premi BPJS Ketenagakerjaan per peserta
    const PREMI_PER_PESERTA = 8400;

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
}