<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerApprovalHistory extends Model
{
    protected $fillable = [
        'service_estimate_history_id',
        'customer_contact_id',
        'decision',
        'decided_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'decided_at' => 'datetime',
        ];
    }

    public function serviceEstimateHistory(): BelongsTo
    {
        return $this->belongsTo(ServiceEstimateHistory::class);
    }

    public function customerContact(): BelongsTo
    {
        return $this->belongsTo(CustomerContact::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
