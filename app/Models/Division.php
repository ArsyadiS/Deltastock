<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $fillable = [
        'name', 
        'code', 
        'description', 
        'active'];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    // ── Relations ──────────────────────────────
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

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
    public static function createDivision(array $data): self
    {
        return self::create([
            'name'        => $data['name'],
            'code'        => strtoupper($data['code']),
            'description' => $data['description'] ?? null,
            'active'      => $data['active'] ?? true,
        ]);
    }

    public function updateDivision(array $data): self
    {
        $this->update([
            'name'        => $data['name'],
            'code'        => strtoupper($data['code']),
            'description' => $data['description'] ?? null,
            'active'      => $data['active'] ?? true,
        ]);

        return $this;
    }

    public function canBeDeleted(): bool
    {
        return $this->items()->count() === 0 &&
               $this->categories()->count() === 0;
    }
}