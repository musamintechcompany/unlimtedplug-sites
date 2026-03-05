<?php

namespace Database\Seeders;

use App\Models\RentableProject;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RentalTestSeeder extends Seeder
{
    public function run(): void
    {
        // Create test rentable projects
        RentableProject::create([
            'id' => Str::uuid(),
            'name' => 'Shipping Pro',
            'slug' => 'shipping-pro',
            'description' => 'Professional shipping management system',
            'type' => 'shipping',
            'api_url' => 'http://localhost:8002/api',
            'api_key' => null,
            'pricing_24h' => 10,
            'pricing_7d' => 50,
            'pricing_30d' => 150,
            'details' => json_encode([
                'features' => ['real-time-tracking', 'multi-carrier', 'label-printing'],
            ]),
            'status' => 'active',
        ]);

        RentableProject::create([
            'id' => Str::uuid(),
            'name' => 'Shipping Basic',
            'slug' => 'shipping-basic',
            'description' => 'Basic shipping management system',
            'type' => 'shipping',
            'api_url' => 'http://localhost:8002/api',
            'api_key' => null,
            'pricing_24h' => 5,
            'pricing_7d' => 25,
            'pricing_30d' => 75,
            'details' => json_encode([
                'features' => ['basic-tracking', 'single-carrier'],
            ]),
            'status' => 'active',
        ]);

        // Create test user with credits
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'status' => 'active',
            'theme' => 'light',
        ]);

        // Create wallet with credits
        Wallet::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'credits_balance' => 500,
        ]);
    }
}
