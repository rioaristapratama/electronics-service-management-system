<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationRecord extends Model
{
    protected $fillable = [
        'service_item_id',
        'communication_log_id',
        'notification_type',
        'delivery_status',
        'recipient_name',
        'recipient_phone',
        'message',
        'proof_path',
        'attempted_at',
        'delivered_at',
        'failure_reason',
    ];

    protected function casts(): array
    {
        return [
            'attempted_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function communicationLog(): BelongsTo
    {
        return $this->belongsTo(CommunicationLog::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
