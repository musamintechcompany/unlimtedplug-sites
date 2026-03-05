<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentableProject extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'api_url',
        'api_key',
        'pricing_24h',
        'pricing_7d',
        'pricing_30d',
        'pricing_365d',
        'sort_order',
        'details',
        'status',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'features' => 'array',
    ];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
