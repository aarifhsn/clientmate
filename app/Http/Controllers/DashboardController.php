<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients' => Client::count(),
            'connected' => Client::where('connected', true)->count(),
            'not_connected' => Client::where('connected', false)->count(),
            'active' => Client::where('last_visited_at', '>=', now()->subDays(3))->count(),
            'warm' => Client::whereBetween('last_visited_at', [now()->subDays(7), now()->subDays(3)])->count(),
            'cold' => Client::where(function ($q) {
                $q->whereNull('last_visited_at')
                    ->orWhere('last_visited_at', '<=', now()->subDays(7));
            })->count(),
            'inactive' => Client::where(function ($q) {
                $q->whereNull('last_visited_at')
                    ->orWhere('last_visited_at', '<=', now()->subDays(10));
            })->count(),
            'overdue_followups' => Client::where('next_follow_up', '<', now())->count(),
            'today_followups' => Client::whereDate('next_follow_up', today())->count(),
            'favorites' => Client::where('is_favorite', true)->count(),
        ];

        // Recent clients (oldest visits first, never visited at top)
        $recentClients = Client::with('category')
            ->orderByRaw('last_visited_at IS NULL DESC')
            ->orderBy('last_visited_at', 'asc')
            ->limit(10)
            ->get();

        // Today's follow-ups
        $todayFollowups = Client::with('category')
            ->whereDate('next_follow_up', today())
            ->get();

        // Overdue follow-ups
        $overdueFollowups = Client::with('category')
            ->where('next_follow_up', '<', now())
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentClients' => $recentClients,
            'todayFollowups' => $todayFollowups,
            'overdueFollowups' => $overdueFollowups,
        ]);
    }

}
