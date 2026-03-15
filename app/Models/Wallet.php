<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Wallet extends Model
{
    use HasUuids;
    protected $fillable = [
        'id',
        'user_id',
        'credits_balance',
    ];

    protected $casts = [
        'credits_balance' => 'decimal:2',
    ];

    // Accessor for backward compatibility
    public function getBalanceAttribute()
    {
        return $this->credits_balance;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }
}
