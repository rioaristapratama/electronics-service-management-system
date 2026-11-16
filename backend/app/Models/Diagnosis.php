<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diagnosis extends Model
{
    protected $fillable = [
        'service_item_id',
        'diagnosis',
        'recommended_action',
        'diagnosed_at',
    ];

    protected function casts(): array
    {
        return [
            'diagnosed_at' => 'datetime',
        ];
    }

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function diagnosedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diagnosed_by');
    }
}
