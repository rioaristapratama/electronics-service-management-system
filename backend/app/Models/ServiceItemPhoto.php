<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceItemPhoto extends Model
{
    protected $fillable = [
        'service_item_id',
        'photo_type',
        'file_path',
        'caption',
        'uploaded_at',
        'replaces_photo_id',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
        ];
    }

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function replacesPhoto(): BelongsTo
    {
        return $this->belongsTo(
            ServiceItemPhoto::class,
            'replaces_photo_id'
        );
    }

    public function replacementPhotos(): HasMany
    {
        return $this->hasMany(
            ServiceItemPhoto::class,
            'replaces_photo_id'
        );
    }
}
