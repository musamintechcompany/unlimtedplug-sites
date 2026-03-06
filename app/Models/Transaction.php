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
        'type',
        'description',
        'currency',
        'price',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function transactable(): MorphTo
    {
        return $this->morphTo();
    }
}
