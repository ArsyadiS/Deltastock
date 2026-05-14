<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'code',
        'phone',
        'email',
        'address',
        'contact_person',
        'active',
    ];

    /**
     * Get the items for the supplier.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}