<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranUangSaku extends Model
{
    const TARIF_PER_HARI = 20000;
    
    protected $table = 'pembayaran_uang_sakus';
    
    protected $fillable = [
        'no_kuitansi',
        'kelas_id',
        'peserta_id',
        'total_uang',
        'tgl_spby',
        'hari_kehadiran',
        'keterangan',
        'detail_peserta'
    ];

    protected $casts = [
        'tgl_spby' => 'date',
        'total_uang' => 'decimal:2',
        'hari_kehadiran' => 'integer',
        'detail_peserta' => 'array'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}