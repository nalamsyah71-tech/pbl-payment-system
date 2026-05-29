<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name', 'code', 'icon', 'is_active', 'sort_order', 'config'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array',
    ];
}