<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)
        ->except(['update']); // Exclude default update route
    Route::post('blogs/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'update'])->name('blogs.update');

    Route::resource('services', \App\Http\Controllers\Admin\ServicesController::class)
        ->except(['update']); // Exclude default update route
    Route::post('services/{service}', [\App\Http\Controllers\Admin\ServicesController::class, 'update'])->name('services.update');
});