<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranUangSaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'no_kuitansi',
        'tgl_spby',
        'total_uang',
        'detail_peserta',
    ];

    protected $casts = [
        'tgl_spby'       => 'date',
        'detail_peserta' => 'array',
        'total_uang'     => 'decimal:2',
    ];

    // Tarif uang saku per hari
    const TARIF_PER_HARI = 20000;

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
}