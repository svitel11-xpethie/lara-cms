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


    // BLOGS
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)
        ->except(['update']); // Exclude default update route
    Route::post('blogs/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'update'])->name('blogs.update');


    // SERVICES
    Route::resource('services', \App\Http\Controllers\Admin\ServicesController::class)
        ->except(['update']); // Exclude default update route
    Route::post('services/{service}', [\App\Http\Controllers\Admin\ServicesController::class, 'update'])->name('services.update');


    // GALLERIES
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['show']);
    Route::get('galleries/images', [\App\Http\Controllers\Admin\GalleryController::class, 'images'])->name('galleries.images');
    Route::post('galleries/update-order', [\App\Http\Controllers\Admin\GalleryController::class, 'updateOrder'])->name('galleries.updateOrder');


    // CLOUD
    Route::post('/cloud/upload', [\App\Http\Controllers\Admin\CloudController::class, 'upload'])->name('cloud.upload');
    Route::delete('/cloud/delete/{id}', [\App\Http\Controllers\Admin\CloudController::class, 'delete'])->name('cloud.delete');
    Route::get('/cloud/images', [\App\Http\Controllers\Admin\CloudController::class, 'images'])->name('cloud.images');
    Route::get('/cloud', [\App\Http\Controllers\Admin\CloudController::class, 'index'])->name('cloud.index');
});
