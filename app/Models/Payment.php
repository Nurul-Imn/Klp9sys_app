<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'transaction_id',
        'gateway',
        'amount',
        'currency',
        'payment_method',
        'status',
        'payment_status',
        'paid_at',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'paid_at' => 'datetime',
            'payload' => 'array',
            'status' => 'string',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
