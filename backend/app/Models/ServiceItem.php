<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Diagnosis;
use App\Models\ServiceEstimateHistory;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_order_id',
        'category_id',
        'device_name',
        'brand',
        'model',
        'serial_number',
        'complaint',
        'physical_condition',
        'accessories',
    ];

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DeviceCategory::class);
    }

    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function estimateHistories(): HasMany
    {
        return $this->hasMany(ServiceEstimateHistory::class);
    }
}
