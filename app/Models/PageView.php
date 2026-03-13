<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PageView extends Model
{
    use HasUuids;

    protected $fillable = [
        'visitor_id',
        'url',
        'page_type',
        'page_id',
        'action',
        'metadata',
        'time_spent',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
