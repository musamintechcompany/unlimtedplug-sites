<?php

return [
    'default_currency' => 'USD',
    
    'flutterwave' => [
        'public_key' => env('APP_ENV') === 'production' 
            ? env('FLUTTERWAVE_LIVE_PUBLIC_KEY') 
            : env('FLUTTERWAVE_TEST_PUBLIC_KEY'),
        'secret_key' => env('APP_ENV') === 'production' 
            ? env('FLUTTERWAVE_LIVE_SECRET_KEY') 
            : env('FLUTTERWAVE_TEST_SECRET_KEY'),
        'encryption_key' => env('APP_ENV') === 'production' 
            ? env('FLUTTERWAVE_LIVE_ENCRYPTION_KEY') 
            : env('FLUTTERWAVE_TEST_ENCRYPTION_KEY'),
    ],
    
    'currencies' => [
        'USD' => ['name' => 'US Dollar', 'symbol' => '$', 'price_per_10' => 1.00],
        'GBP' => ['name' => 'British Pound', 'symbol' => '£', 'price_per_10' => 0.80],
        'EUR' => ['name' => 'Euro', 'symbol' => '€', 'price_per_10' => 0.90],
        'NGN' => ['name' => 'Nigerian Naira', 'symbol' => '₦', 'price_per_10' => 1384],
        'GHS' => ['name' => 'Ghanaian Cedi', 'symbol' => 'GH₵', 'price_per_10' => 10.80],
        'KES' => ['name' => 'Kenyan Shilling', 'symbol' => 'KSh', 'price_per_10' => 129.20],
        'ZAR' => ['name' => 'South African Rand', 'symbol' => 'R', 'price_per_10' => 16.60],
        'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'C$', 'price_per_10' => 1.40],
        'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'A$', 'price_per_10' => 1.40],
    ],
    
    'packages' => [
        100 => ['bonus' => 0, 'savings' => 0],
        500 => ['bonus' => 50, 'savings' => 10],
    ],
    
    'country_currency_map' => [
        'US' => 'USD', 'CA' => 'CAD', 'GB' => 'GBP', 'AU' => 'AUD',
        'NG' => 'NGN', 'GH' => 'GHS', 'KE' => 'KES', 'ZA' => 'ZAR',
        'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR', 'ES' => 'EUR',
    ],
];
