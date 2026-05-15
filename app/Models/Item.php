<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'code',
        'name',
        'division_id',
        'category_id',
        'unit_id',
        'supplier_id',
        'min_stock',
        'max_stock',
        'description',
        'active',
    ];

    /**
     * Get the division that owns the item.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the category that owns the item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the unit that owns the item.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the supplier that owns the item.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the batches for the item.
     */
    public function batches(): HasMany
    {
        return $this->hasMany(ItemBatch::class);
    }
    
    /**
     * Get the current stock for the item.
     */
    public function getTotalStockAttribute(): float
    {
        return $this->batches()->sum('current_stock');
    }

    
}