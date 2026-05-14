<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemBatch extends Model
{
    protected $fillable = [
        'item_id',
        'batch_number',
        'production_date',
        'expired_date',
        'qty_in',
        'qty_out',
        'current_stock',
        'note',
        'active',
    ];

    /**
     * Get the casts for the batch.
     */
    protected function casts(): array
    {
        return [
            'production_date' => 'date',
            'expired_date' => 'date',
        ];
    }

    /**
     * Get the item that owns the batch.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Check if the batch is expired.
     */
    public function isExpired(): bool
    {
        return $this->expired_date && $this->expired_date->isPast();
    }

    /**
     * Check if the batch is near expiry.
     */
    public function isNearExpiry(int $days = 90): bool
    {
        return $this->expired_date && $this->expired_date->diffInDays(now()) <= $days;
    }

}
