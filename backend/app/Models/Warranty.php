<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warranty extends Model
{
    protected $fillable = [
        'service_item_id',
        'handover_record_id',
        'starts_at',
        'expires_at',
        'is_eligible',
        'exclusion_reason',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_eligible' => 'boolean',
        ];
    }

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function handoverRecord(): BelongsTo
    {
        return $this->belongsTo(
            ServiceHandoverRecord::class,
            'handover_record_id'
        );
    }
}
