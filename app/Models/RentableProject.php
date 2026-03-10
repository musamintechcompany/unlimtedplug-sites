<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentableProject extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'subcategory_id',
        'api_url',
        'api_key',
        'api_secret',
        'pricing_24h',
        'pricing_7d',
        'pricing_30d',
        'pricing_365d',
        'sort_order',
        'banner_image',
        'media_images',
        'is_buyable',
        'is_rentable',
        'details',
        'status',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'features' => 'array',
        'media_images' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
