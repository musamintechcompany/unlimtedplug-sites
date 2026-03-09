<?php

namespace App\Policies;

use App\Models\ApiKey;
use App\Models\User;

class ApiKeyPolicy
{
    public function view(User $user, ApiKey $apiKey): bool
    {
        return $user->id === $apiKey->keyable_id && $apiKey->keyable_type === User::class;
    }

    public function update(User $user, ApiKey $apiKey): bool
    {
        return $user->id === $apiKey->keyable_id && $apiKey->keyable_type === User::class;
    }

    public function delete(User $user, ApiKey $apiKey): bool
    {
        return $user->id === $apiKey->keyable_id && $apiKey->keyable_type === User::class;
    }
}
