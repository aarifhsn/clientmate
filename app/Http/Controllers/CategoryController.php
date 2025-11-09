<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('clients')->get();
        $clients = Client::with('category')->get();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'clients' => $clients
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function show(Category $category)
    {
        // Load all clients for this category
        $category->load('clients');

        return Inertia::render('Categories/Show', [
            'category' => $category,
            'clients' => $category->clients,
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7'
        ]);

        $validated['user_id'] = auth()->id();

        Category::create($validated);

        return redirect()->back()
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'color' => 'string|max:7'
        ]);

        $validated['user_id'] = auth()->id();

        $category->update($validated);

        return redirect()->back()
            ->with('success', 'Category updated successfully!');
    }
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()
            ->with('success', 'Category deleted successfully!');
    }


}
