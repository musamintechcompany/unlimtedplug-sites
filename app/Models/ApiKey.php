<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
    use HasUuids, SoftDeletes;
    protected $fillable = [
        'keyable_type',
        'keyable_id',
        'name',
        'key',
        'requests_count',
        'last_used_at',
        'status',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
    ];

    public function keyable(): MorphTo
    {
        return $this->morphTo();
    }

    public function incrementUsage(): void
    {
        $this->increment('requests_count');
        $this->update(['last_used_at' => now()]);
    }
}
