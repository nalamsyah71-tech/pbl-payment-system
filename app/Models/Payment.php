<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_number', 'user_id', 'peserta_id', 'amount', 'paid_amount', 'status',
        'payment_method', 'external_id', 'payment_details', 'expired_at',
        'paid_at', 'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'payment_details' => 'array',
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }

    public function markAsSuccess(): void
    {
        $this->update([
            'status' => 'success',
            'paid_amount' => $this->amount,
            'paid_at' => now(),
        ]);
    }

    public function isExpired(): bool
    {
        return $this->expired_at && now()->gt($this->expired_at);
    }
}