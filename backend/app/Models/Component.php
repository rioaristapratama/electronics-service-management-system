<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Component extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }


    public function serviceItems(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceItem::class,
            'service_item_components'
        )->withPivot([
            'quantity',
            'usage_status',
            'ordered_at',
            'expected_at',
            'notes',
        ])->withTimestamps();
    }
}
