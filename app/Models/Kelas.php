<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'pelatihan_id',
        'nama_kelas',
        'tgl_mulai',
        'tgl_selesai',
        'hari_efektif',
        'mak_pulsa',
        'mak_asuransi',
        'mak_uang_saku',
    ];

    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
    ];

    public function pelatihan(): BelongsTo
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function pesertas(): HasMany
    {
        return $this->hasMany(Peserta::class);
    }

    public function pembayaranPulsas(): HasMany
    {
        return $this->hasMany(PembayaranPulsa::class);
    }

    public function pembayaranAsuransis(): HasMany
    {
        return $this->hasMany(PembayaranAsuransi::class);
    }

    public function pembayaranUangSakus(): HasMany
    {
        return $this->hasMany(PembayaranUangSaku::class);
    }

    /**
     * Accessor: label lengkap untuk dropdown
     */
    public function getLabelAttribute(): string
    {
        return $this->nama_kelas . ' (' . $this->pelatihan->nama . ')';
    }
}