<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceEstimateHistory extends Model
{
    protected $fillable = [
        'service_item_id',
        'estimated_labor_cost',
        'estimated_parts_cost',
        'estimated_other_cost',
        'total_estimated_cost',
        'notes',
        'estimated_at',
    ];

    protected function casts(): array
    {
        return [
            'estimated_labor_cost' => 'decimal:2',
            'estimated_parts_cost' => 'decimal:2',
            'estimated_other_cost' => 'decimal:2',
            'total_estimated_cost' => 'decimal:2',
            'estimated_at' => 'datetime',
        ];
    }

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function approvalHistories(): HasMany
    {
        return $this->hasMany(CustomerApprovalHistory::class);
    }
}
