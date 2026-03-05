<?php

return [
    'default_currency' => 'USD',
    
    'currencies' => [
        'USD' => ['name' => 'US Dollar', 'symbol' => '$', 'price_per_10' => 1],
        'GBP' => ['name' => 'British Pound', 'symbol' => '£', 'price_per_10' => 0.8],
        'EUR' => ['name' => 'Euro', 'symbol' => '€', 'price_per_10' => 0.9],
        'NGN' => ['name' => 'Nigerian Naira', 'symbol' => '₦', 'price_per_10' => 1384],
        'GHS' => ['name' => 'Ghanaian Cedi', 'symbol' => 'GH₵', 'price_per_10' => 10.8],
        'KES' => ['name' => 'Kenyan Shilling', 'symbol' => 'KSh', 'price_per_10' => 129.2],
        'ZAR' => ['name' => 'South African Rand', 'symbol' => 'R', 'price_per_10' => 16.6],
        'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'CA$', 'price_per_10' => 1.4],
        'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'A$', 'price_per_10' => 1.4],
    ],
    
    // Country to Currency mapping for auto-detection
    'country_currency_map' => [
        'US' => 'USD', 'CA' => 'CAD', 'GB' => 'GBP', 'AU' => 'AUD',
        'NG' => 'NGN', 'GH' => 'GHS', 'KE' => 'KES', 'ZA' => 'ZAR',
        // European countries using EUR
        'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR', 'ES' => 'EUR', 'NL' => 'EUR',
        'BE' => 'EUR', 'AT' => 'EUR', 'PT' => 'EUR', 'IE' => 'EUR', 'GR' => 'EUR',
    ],
    
    // Credit packages with multipliers
    'packages' => [
        100 => ['bonus' => 0, 'savings' => 0],
        500 => ['bonus' => 50, 'savings' => 10],
    ],
];
