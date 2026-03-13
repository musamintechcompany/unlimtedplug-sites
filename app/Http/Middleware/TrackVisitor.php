<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\PageView;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin routes
        if ($request->is('admin') || $request->is('admin/*')) {
            return $next($request);
        }
        
        // Also check for custom admin prefix from settings
        try {
            $adminPrefix = \App\Models\Setting::get('admin_login_prefix', 'admin');
            if ($request->is($adminPrefix) || $request->is($adminPrefix . '/*')) {
                return $next($request);
            }
        } catch (\Exception $e) {
            // If settings table doesn't exist yet, continue
        }
        
        // Skip API routes
        if ($request->is('api/*')) {
            return $next($request);
        }
        
        $this->trackVisit($request);
        
        return $next($request);
    }
    
    private function trackVisit($request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $visitorId = md5($ip . $userAgent);
        
        $visitor = Visitor::where('visitor_id', $visitorId)->first();
        
        if ($visitor) {
            $visitor->update([
                'last_visit' => now(),
                'user_id' => auth()->id() ?? $visitor->user_id,
            ]);
        } else {
            $location = $this->getLocation($request);
            $visitor = Visitor::create([
                'visitor_id' => $visitorId,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'device_type' => $this->getDeviceType($userAgent),
                'country' => $location['country'] ?? null,
                'city' => $location['city'] ?? null,
                'referrer' => $request->header('referer'),
                'user_id' => auth()->id(),
                'first_visit' => now(),
                'last_visit' => now(),
                'data' => ['visits' => 0]
            ]);
        }
        
        // Track page view
        $this->trackPageView($visitor, $request);
        
        // Update visit count
        $data = $visitor->data ?? [];
        $data['visits'] = ($data['visits'] ?? 0) + 1;
        $visitor->update(['data' => $data]);
    }
    
    private function trackPageView($visitor, $request)
    {
        $url = $request->fullUrl();
        $path = $request->path();
        
        $pageData = $this->parsePageData($path, $request);
        
        // Check if same page was viewed in last 15 minutes
        $recentView = PageView::where('visitor_id', $visitor->id)
            ->where('page_type', $pageData['type'])
            ->where('page_id', $pageData['id'])
            ->where('created_at', '>=', now()->subMinutes(15))
            ->exists();
        
        if (!$recentView) {
            PageView::create([
                'visitor_id' => $visitor->id,
                'url' => $url,
                'page_type' => $pageData['type'],
                'page_id' => $pageData['id'],
                'action' => $pageData['action'],
                'metadata' => $pageData['metadata'],
            ]);
        }
    }
    
    private function parsePageData($path, $request)
    {
        $data = ['type' => 'page', 'id' => null, 'action' => 'view', 'metadata' => []];
        
        // Project page
        if (preg_match('/projects\/([a-zA-Z0-9\-]+)/', $path, $matches)) {
            $data['type'] = 'project';
            $data['id'] = $matches[1];
        }
        // Browse page
        elseif (str_contains($path, 'browse')) {
            $data['type'] = 'browse';
        }
        // Credits page
        elseif (str_contains($path, 'credits')) {
            $data['type'] = 'credits';
        }
        // Rentals page
        elseif (str_contains($path, 'rentals')) {
            $data['type'] = 'rentals';
        }
        // Profile page
        elseif (str_contains($path, 'profile')) {
            $data['type'] = 'profile';
        }
        // Home
        elseif ($path === '/' || $path === '') {
            $data['type'] = 'home';
        }
        
        return $data;
    }
    
    private function getDeviceType($userAgent)
    {
        if (preg_match('/mobile|android|iphone|ipad|phone/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            return 'tablet';
        }
        return 'desktop';
    }
    
    private function getLocation($request)
    {
        // Use Cloudflare headers (zero latency, no rate limits)
        $country = $request->header('CF-IPCountry');
        $city = $request->header('CF-IPCity');
        
        return [
            'country' => $country && $country !== 'XX' ? $country : null,
            'city' => $city ?: null,
        ];
    }
}
