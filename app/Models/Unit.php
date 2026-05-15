<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'description',
    ];

    /**
     * Get the items for the unit.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // ── Business Logic ─────────────────────────
    public static function createUnit(array $data): self
    {
        return self::create([
            'name'        => $data['name'],
            'symbol'      => strtoupper($data['symbol']),
            'description' => $data['description'] ?? null,
        ]);
    }

    public function updateUnit(array $data): self
    {
        $this->update([
            'name'        => $data['name'],
            'symbol'      => strtoupper($data['symbol']),
            'description' => $data['description'] ?? null,
        ]);

        return $this;
    }

    public function canBeDeleted(): bool
    {
        return $this->items()->count() === 0;
    }
}