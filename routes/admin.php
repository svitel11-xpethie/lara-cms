<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CloudController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanySeoController;
use App\Http\Controllers\Admin\CompanyTeamController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\CompanySocialController;
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
        ->except(['update', 'show']); // Exclude default update route
    Route::post('services/{service}', [ServicesController::class, 'update'])->name('services.update');
    Route::get('services/all', [ServicesController::class, 'services'])->name('services.services');
    Route::post('services/update/order', [ServicesController::class, 'updateOrder'])->name('services.updateOrder');

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

        Route::resource('team', CompanyTeamController::class)->except(['show', 'create', 'edit', 'update']);
        Route::post('team/update/order', [CompanyTeamController::class, 'updateOrder'])->name('team.updateOrder');
        Route::post('team/{member}', [CompanyTeamController::class, 'update'])->name('team.update');
        Route::get('team/members', [CompanyTeamController::class, 'members'])->name('team.members');

        Route::resource('social', CompanySocialController::class)->except(['show', 'create', 'edit', 'update']);
        Route::post('social/update/order', [CompanySocialController::class, 'updateOrder'])->name('social.updateOrder');
        Route::post('social/{social}', [CompanySocialController::class, 'update'])->name('social.update');
        Route::get('social/profiles', [CompanySocialController::class, 'profiles'])->name('social.profiles');

        Route::resource('seo', CompanySeoController::class)->except(['show', 'create', 'edit']);
        Route::get('seo/metas', [CompanySeoController::class, 'metas'])->name('seo.metas');
        Route::post('seo/update/order', [CompanySeoController::class, 'updateOrder'])->name('seo.updateOrder');
    });
});
