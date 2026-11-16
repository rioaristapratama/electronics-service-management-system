<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarrantyClaim extends Model
{
    protected $fillable = [
        'warranty_id',
        'reported_at',
        'recorded_at',
        'issue_description',
        'decision',
        'decided_at',
        'decision_notes',
        'proof_path',
    ];

    protected function casts(): array
    {
        return [
            'reported_at' => 'datetime',
            'recorded_at' => 'datetime',
            'decided_at' => 'datetime',
        ];
    }

    public function warranty(): BelongsTo
    {
        return $this->belongsTo(Warranty::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function decidedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
