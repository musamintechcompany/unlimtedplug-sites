<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use App\Services\NotificationService;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'password',
        'theme',
        'profile_photo_path',
        'status',
        'email_verified_at',
        'email_verification_code',
        'verification_code_expires_at',
        'password_reset_code',
        'password_reset_code_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verification_code_expires_at' => 'datetime',
            'password_reset_code_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            Wallet::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'credits_balance' => 0,
            ]);
            
            $appName = config('app.name');
            NotificationService::create(
                $user,
                'welcome',
                "Welcome to {$appName}!",
                'Welcome to our platform! Start by exploring projects or purchasing credits to get started.'
            );
        });
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function creditTransactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactable');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function apiKeys(): MorphMany
    {
        return $this->morphMany(ApiKey::class, 'keyable');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
