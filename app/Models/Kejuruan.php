<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kejuruan extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    /**
     * Relasi ke Pelatihan (satu kejuruan punya banyak pelatihan)
     */
    public function pelatihans(): HasMany
    {
        return $this->hasMany(Pelatihan::class);
    }
}