<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, HasRoles, SoftDeletes;

    protected $guard_name = 'admin';

    protected $fillable = ['name', 'email', 'password', 'theme', 'status', 'profile_photo_path', 'created_by', 'two_factor_enabled', 'two_factor_secret', 'login_verification_code', 'login_attempts', 'last_login_at', 'last_login_ip'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'password' => 'hashed',
        'created_by' => 'array',
        'two_factor_enabled' => 'boolean',
        'login_verification_code_expires_at' => 'datetime',
        'last_login_attempt_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($admin) {
            if ($admin->isForceDeleting()) {
                // Force delete related data if needed
            } else {
                $admin->update(['status' => 'inactive']);
            }
        });

        static::restored(function ($admin) {
            $admin->update(['status' => 'active']);
        });
    }
}
