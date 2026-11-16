<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentAllocation extends Model
{
    protected $fillable = [
        'payment_id',
        'service_item_id',
        'allocated_amount',
        'allocation_type',
        'allocated_at',
    ];

    protected function casts(): array
    {
        return [
            'allocated_amount' => 'decimal:2',
            'allocated_at' => 'datetime',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }
}
