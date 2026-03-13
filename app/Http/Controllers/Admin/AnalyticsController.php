<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RentableProject;
use App\Models\Visitor;
use App\Models\PageView;
use App\Models\Rental;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $stats = [
            'total_page_views' => PageView::count(),
            'unique_visitors_today' => Visitor::whereDate('last_visit', today())->count(),
            'page_views_today' => PageView::whereDate('created_at', today())->count(),
            'total_visitors' => Visitor::count(),
        ];
        
        $topPages = PageView::selectRaw('page_type, COUNT(*) as views')
            ->groupBy('page_type')
            ->orderByDesc('views')
            ->limit(5)
            ->get();
        
        $topCountries = Visitor::selectRaw('country, COUNT(*) as count')
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        $topProjects = PageView::where('page_type', 'project')
            ->whereNotNull('page_id')
            ->selectRaw('page_id, COUNT(*) as views')
            ->groupBy('page_id')
            ->orderByDesc('views')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $item->project = RentableProject::find($item->page_id);
                return $item;
            })
            ->filter(fn($item) => $item->project !== null);
        
        return view('admin.analytics.index', compact(
            'stats',
            'topPages',
            'topCountries',
            'topProjects'
        ));
    }
    
    public function visitors()
    {
        $visitors = Visitor::with('user', 'pageViews')
            ->orderByDesc('last_visit')
            ->paginate(50);
        
        return view('admin.analytics.visitors', compact('visitors'));
    }
    
    public function deleteOldData(Request $request)
    {
        $days = $request->input('days', 90);
        
        if ($days === 'all') {
            $deletedPageViews = PageView::count();
            $deletedVisitors = Visitor::count();
            
            // Delete page_views first (has foreign key to visitors)
            PageView::query()->delete();
            Visitor::query()->delete();
            
            return redirect()->back()->with('success', "Deleted all tracking data: {$deletedVisitors} visitors and {$deletedPageViews} page views.");
        }
        
        $date = now()->subDays($days);
        $deletedPageViews = PageView::where('created_at', '<', $date)->delete();
        $deletedVisitors = Visitor::where('last_visit', '<', $date)->delete();
        
        return redirect()->back()->with('success', "Deleted {$deletedVisitors} visitors and {$deletedPageViews} page views older than {$days} days.");
    }

    public function getVisitorChartData(Request $request)
    {
        $period = $request->input('period', 30);
        
        $labels = [];
        $pageViews = [];
        $visitors = [];
        
        $dateRange = $this->getDateRange($period);
        
        foreach ($dateRange as $date) {
            $labels[] = $date['label'];
            
            $pageViews[] = PageView::whereBetween('created_at', [$date['start'], $date['end']])->count();
            $visitors[] = Visitor::whereBetween('last_visit', [$date['start'], $date['end']])->count();
        }
        
        return response()->json([
            'labels' => $labels,
            'pageViews' => $pageViews,
            'visitors' => $visitors
        ]);
    }
    
    private function getDateRange($period)
    {
        $dates = [];
        $now = Carbon::now();
        
        if ($period <= 30) {
            // Daily data
            for ($i = $period - 1; $i >= 0; $i--) {
                $date = $now->copy()->subDays($i);
                $dates[] = [
                    'label' => $date->format('M d'),
                    'start' => $date->copy()->startOfDay(),
                    'end' => $date->copy()->endOfDay()
                ];
            }
        } elseif ($period <= 90) {
            // Weekly data
            $weeks = ceil($period / 7);
            for ($i = $weeks - 1; $i >= 0; $i--) {
                $startDate = $now->copy()->subWeeks($i)->startOfWeek();
                $endDate = $now->copy()->subWeeks($i)->endOfWeek();
                $dates[] = [
                    'label' => $startDate->format('M d'),
                    'start' => $startDate->copy(),
                    'end' => $endDate->copy()
                ];
            }
        } else {
            // Monthly data
            $months = ceil($period / 30);
            for ($i = $months - 1; $i >= 0; $i--) {
                $date = $now->copy()->subMonths($i);
                $dates[] = [
                    'label' => $date->format('M Y'),
                    'start' => $date->copy()->startOfMonth(),
                    'end' => $date->copy()->endOfMonth()
                ];
            }
        }
        
        return $dates;
    }
}
