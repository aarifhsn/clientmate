<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'total_clients' => Client::where('user_id', $userId)->count(),
            'connected_clients' => Client::where('user_id', $userId)->where('connected', true)->count(),
            'not_connected' => Client::where('user_id', $userId)->where('connected', false)->count(),
            'active' => Client::where('user_id', $userId)
                ->where('last_visited_at', '>=', now()->subDays(3))
                ->count(),
            'warm' => Client::where('user_id', $userId)
                ->whereBetween('last_visited_at', [now()->subDays(7), now()->subDays(3)])
                ->count(),
            'cold' => Client::where('user_id', $userId)
                ->where(function ($q) {
                    $q->whereNull('last_visited_at')
                        ->orWhere('last_visited_at', '<=', now()->subDays(7));
                })->count(),
            'inactive' => Client::where('user_id', $userId)
                ->where(function ($q) {
                    $q->whereNull('last_visited_at')
                        ->orWhere('last_visited_at', '<=', now()->subDays(10));
                })->count(),
            'overdue_followups' => Client::where('user_id', $userId)
                ->where('next_follow_up', '<', now())
                ->count(),
            'today_followups' => Client::where('user_id', $userId)
                ->whereDate('next_follow_up', today())
                ->count(),
            'favorite_clients' => Client::where('user_id', $userId)
                ->where('is_favorite', true)
                ->count(),
            'high_priority_clients' => Client::where('user_id', $userId)
                ->where('priority', 'high')
                ->count(),
        ];

        // Recent clients
        $recentClients = Client::with('category')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Today's follow-ups
        $todayFollowups = Client::with('category')
            ->where('user_id', $userId)
            ->whereDate('next_follow_up', today())
            ->get();

        // Overdue follow-ups
        $overdueFollowups = Client::with('category')
            ->where('user_id', $userId)
            ->where('next_follow_up', '<', now())
            ->get();

        // Upcoming follow-ups (next 5 days)
        $upcomingFollowUps = Client::with('category')
            ->where('user_id', $userId)
            ->whereBetween('next_follow_up', [now(), now()->addDays(5)])
            ->orderBy('next_follow_up', 'asc')
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentClients' => $recentClients,
            'todayFollowups' => $todayFollowups,
            'overdueFollowups' => $overdueFollowups,
            'upcomingFollowUps' => $upcomingFollowUps,
            'categories' => Category::withCount([
                'clients' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }
            ])->get(),
        ]);

    }
}