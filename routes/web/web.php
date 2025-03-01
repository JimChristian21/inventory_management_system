<?php

use App\Http\Controllers\{
    Inventory,
    Items,
    ProfileController,
    Users
};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function() {

    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware('auth')->group(function () {

Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [Users::class, 'index'])->name('user.index');
    Route::post('/users', [Users::class, 'store'])->name('user.store');
    Route::patch('/users/{id}', [Users::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [Users::class, 'destroy'])->name('user.delete');

    Route::get('/inventory', [Inventory::class, 'index'])->name('inventory.index');

    Route::post('/items', [Items::class, 'store'])->name('item.store');
    Route::patch('/items/{id}', [Items::class, 'update'])->name('item.update');
    Route::delete('/items/{id}', [Items::class, 'destroy'])->name('item.delete');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
});


