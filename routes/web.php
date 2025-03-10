<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


        Route::get('/transactions', function () {
            return Inertia::render('Transactions/Index');
        })->name('transactions.index');

        Route::get('/reports', function () {
            return Inertia::render('Reports/Index');
        })->name('reports.index');

        Route::get('/settings', function () {
            return Inertia::render('Settings/Index');
        })->name('settings.index');
    });
});
