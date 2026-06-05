<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPulsa extends Model
{
    protected $table = 'pembayaran_pulsas';
    
    protected $fillable = [
        'no_kuitansi', 
        'kelas_id', 
        'peserta_id', 
        'total_uang', 
        'tgl_spby', 
        'keterangan',
        'detail_peserta'
    ];
    
    protected $casts = [
        'tgl_spby' => 'date',
        'total_uang' => 'decimal:2',
        'detail_peserta' => 'array',
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