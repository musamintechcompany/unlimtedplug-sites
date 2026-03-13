<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'transactable_type',
        'transactable_id',
        'amount',
        'credits',
        'type',
        'description',
        'currency',
        'price',
        'status',
        'data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'price' => 'decimal:2',
        'data' => 'array',
    ];

    public function transactable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        if ($this->transactable_type === 'App\\Models\\User') {
            return $this->transactable;
        }
        return null;
    }
}
