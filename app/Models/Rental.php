<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'rentable_project_id',
        'duration_days',
        'credits_cost',
        'rental_starts_at',
        'rental_expires_at',
        'renewal_history',
        'details_history',
        'admin_id',
        'admin_email',
        'admin_password',
        'status',
    ];

    protected $casts = [
        'credits_cost' => 'decimal:2',
        'rental_starts_at' => 'datetime',
        'rental_expires_at' => 'datetime',
        'renewal_history' => 'array',
        'details_history' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(RentableProject::class, 'rentable_project_id');
    }

    public function rentableProject(): BelongsTo
    {
        return $this->belongsTo(RentableProject::class, 'rentable_project_id');
    }

    public function isExpired(): bool
    {
        return $this->rental_expires_at->isPast();
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && !$this->isExpired();
    }
}
