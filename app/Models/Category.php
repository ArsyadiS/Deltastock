<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'division_id',
        'name',
        'description',
        'active',
    ];

    /**
     * Get the division that owns the category.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the items for the category.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // ── Scopes ─────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // ── Business Logic ─────────────────────────
    public static function createCategory(array $data): self
    {
        return self::create([
            'division_id'   => $data['division_id'],
            'name'          => $data['name'],
            'description'   => $data['description'] ?? null,
            'active'        => $data['active'] ?? true,
        ]);
}