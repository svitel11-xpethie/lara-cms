<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CloudController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ServicesController;
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
    Route::resource('blogs', BlogController::class)
        ->except(['update']); // Exclude default update route
    Route::post('blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');

    // SERVICES
    Route::resource('services', ServicesController::class)
        ->except(['update']); // Exclude default update route
    Route::post('services/{service}', [ServicesController::class, 'update'])->name('services.update');

    // GALLERIES
    Route::resource('galleries', GalleryController::class)->except(['show', 'update']);
    Route::get('galleries/images', [GalleryController::class, 'images'])->name('galleries.images');
    Route::post('galleries/update-order', [GalleryController::class, 'updateOrder'])->name('galleries.updateOrder');
    Route::post('galleries/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');

    // CLOUD
    Route::post('/cloud/upload', [CloudController::class, 'upload'])->name('cloud.upload');
    Route::delete('/cloud/delete/{id}', [CloudController::class, 'delete'])->name('cloud.delete');
    Route::get('/cloud/images', [CloudController::class, 'images'])->name('cloud.images');
    Route::get('/cloud', [CloudController::class, 'index'])->name('cloud.index');

    // COMPANY
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('profile', [CompanyController::class, 'profile'])->name('profile');
        Route::post('profile/update', [CompanyController::class, 'updateProfile'])->name('updateProfile');

        Route::get('team', [CompanyController::class, 'team'])->name('team');
        Route::post('team', [CompanyController::class, 'storeMember'])->name('team.store');
        Route::put('team/{member}', [CompanyController::class, 'updateMember'])->name('team.update');
        Route::delete('team/{member}', [CompanyController::class, 'deleteMember'])->name('team.delete');

        Route::get('social', [CompanyController::class, 'social'])->name('social');
        Route::post('social', [CompanyController::class, 'storeSocial'])->name('social.store');
        Route::put('social/{social}', [CompanyController::class, 'updateSocial'])->name('social.update');
        Route::delete('social/{social}', [CompanyController::class, 'deleteSocial'])->name('social.delete');

        Route::get('meta', [CompanyController::class, 'meta'])->name('meta');
        Route::put('meta', [CompanyController::class, 'updateMeta'])->name('meta.update');
    });
});
