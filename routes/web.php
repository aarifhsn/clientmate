<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'canLogin' => Route::has('login')
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {

    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::post('/clients/{client}/visit', [ClientController::class, 'recordVisit'])->name('clients.visit');
    Route::post('/clients/{client}/toggle-favorite', [ClientController::class, 'toggleFavorite'])->name('clients.toggle-favorite');
    Route::get('/clients-export', [ClientController::class, 'export'])->name('clients.export');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/clients/{client}/last-visited', [ClientController::class, 'updateLastVisited'])
        ->name('clients.lastVisited');

});

require __DIR__ . '/settings.php';
