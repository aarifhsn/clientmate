<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with('category')
            ->where('user_id', auth()->id());

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('notes', 'like', "%{$request->search}%");
            });
        }

        // Filters
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('connected') && $request->connected !== null) {
            $query->where('connected', $request->boolean('connected'));
        }

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('favorite') && $request->boolean('favorite')) {
            $query->where('is_favorite', true);
        }
        if ($request->has('last_visited') && $request->last_visited !== null) {
            if ($request->boolean('last_visited')) {
                $query->whereNotNull('last_visited_at');
            } else {
                $query->whereNull('last_visited_at');
            }
        }

        // Engagement filter
        if ($request->engagement) {
            switch ($request->engagement) {
                case 'inactive':
                    $query->where(function ($q) {
                        $q->whereNull('last_visited_at')
                            ->orWhere('last_visited_at', '<=', now()->subDays(10));
                    });
                    break;
                case 'active':
                    $query->where('last_visited_at', '>=', now()->subDays(3));
                    break;
                case 'warm':
                    $query->whereBetween('last_visited_at', [now()->subDays(7), now()->subDays(3)]);
                    break;
                case 'cold':
                    $query->where(function ($q) {
                        $q->where('last_visited_at', '<=', now()->subDays(7))
                            ->orWhereNull('last_visited_at');
                    });
                    break;
            }
        }

        // Sorting (default: oldest visits first)
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';

        if ($sortBy === 'last_visited_at') {
            // Nulls first (never visited)
            $query->orderByRaw('last_visited_at IS NULL DESC')
                ->orderBy('last_visited_at', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $clients = $query->paginate(20)->withQueryString();

        $categories = Category::all();

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
            'categories' => $categories,
        ]);
    }

    public function create(): Response
    {
        $categories = Category::all();

        return Inertia::render('Clients/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'linkedin_url' => 'required|url',
            'category_id' => 'nullable|exists:categories,id',
            'priority' => 'required|in:high,medium,low',
            'connected' => 'boolean',
            'is_favorite' => 'boolean',
            'next_follow_up' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully!');
    }

    public function show(Client $client)
    {
        $client->load('category', 'visits');

        return Inertia::render('Clients/Show', [
            'client' => $client,
        ]);
    }

    public function edit(Client $client)
    {
        $categories = Category::all();

        return Inertia::render('Clients/Edit', [
            'client' => $client,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'linkedin_url' => 'url',
            'category_id' => 'nullable|exists:categories,id',
            'priority' => 'in:high,medium,low',
            'connected' => 'boolean',
            'is_favorite' => 'boolean',
            'next_follow_up' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();

        $client->update($validated);

        return redirect()->back()
            ->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully!');
    }

    public function recordVisit(Request $request, Client $client)
    {
        $validated = $request->validate([
            'note' => 'nullable|string'
        ]);

        $client->recordVisit($validated['note'] ?? null);

        return redirect()->back()
            ->with('success', 'Visit recorded successfully!');
    }

    public function updateLastVisited(Client $client)
    {
        $client->update([
            'last_visited_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }


    public function toggleFavorite(Client $client)
    {
        $client->update(['is_favorite' => !$client->is_favorite]);

        return redirect()->back();
    }

    public function export()
    {
        $clients = Client::with('category')->get();

        $csv = "Name,LinkedIn URL,Category,Priority,Connected,Last Visited,Next Follow-up,Engagement Status,Notes\n";

        foreach ($clients as $client) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $client->name,
                $client->linkedin_url,
                $client->category?->name ?? '',
                $client->priority,
                $client->connected ? 'Yes' : 'No',
                $client->last_visited_at?->format('Y-m-d H:i') ?? '',
                $client->next_follow_up?->format('Y-m-d') ?? '',
                $client->engagement_status,
                str_replace('"', '""', $client->notes ?? '')
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="clients-' . date('Y-m-d') . '.csv"');
    }
}
