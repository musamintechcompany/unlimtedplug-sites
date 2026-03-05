<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoDetectCurrency
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only auto-detect if currency is not already set in session
        if (!session()->has('currency')) {
            // Get country code from CloudFlare header (production) or default to US (local)
            $countryCode = $request->header('CF-IPCountry', 'US');
            
            // Map country to currency
            $currencyMap = config('payment.country_currency_map', []);
            $currency = $currencyMap[$countryCode] ?? 'USD';
            
            // Validate currency exists in our supported currencies
            if (array_key_exists($currency, config('payment.currencies', []))) {
                session(['currency' => $currency]);
            } else {
                session(['currency' => 'USD']);
            }
        }

        return $next($request);
    }
}
