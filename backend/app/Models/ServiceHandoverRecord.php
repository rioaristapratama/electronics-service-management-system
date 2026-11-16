<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceHandoverRecord extends Model
{
    protected $fillable = [
        'service_item_id',
        'recipient_name',
        'recipient_phone',
        'recipient_type',
        'authorized_by_contact_id',
        'authorization_method',
        'authorization_notes',
        'proof_path',
        'handed_over_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'handed_over_at' => 'datetime',
        ];
    }

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function handedOverBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handed_over_by');
    }

    public function authorizedByContact(): BelongsTo
    {
        return $this->belongsTo(
            CustomerContact::class,
            'authorized_by_contact_id'
        );
    }
}
