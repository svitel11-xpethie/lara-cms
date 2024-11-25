<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CloudController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanySeoController;
use App\Http\Controllers\Admin\CompanyTeamController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FormRequestController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ScriptController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\CompanySocialController;
use App\Http\Controllers\Admin\TestimonialController;
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

    // FORM REQUESTS
    Route::prefix('form-requests')->name('form_requests.')->group(function () {
        Route::get('/', [FormRequestController::class, 'index'])->name('index'); // List requests
        Route::get('/messages', [FormRequestController::class, 'messages'])->name('messages'); // List requests
        Route::post('/{formRequest}/send-email', [FormRequestController::class, 'sendEmail'])->name('sendEmail'); // Send email
        Route::post('/{formRequest}/send-whatsapp', [FormRequestController::class, 'sendWhatsApp'])->name('sendWhatsApp'); // Send WhatsApp
        Route::delete('/{formRequest}', [FormRequestController::class, 'destroy'])->name('destroy'); // Delete request
    });

    // TESTIMONIALS
    Route::resource('testimonials', TestimonialController::class)->except(['show', 'update']); // Exclude default update route
    Route::post('testimonials/update/order', [TestimonialController::class, 'updateOrder'])->name('testimonials.updateOrder');
    Route::get('testimonials/testimonials', [TestimonialController::class, 'testimonials'])->name('testimonials.testimonials');
    Route::post('testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');

    // SCRIPTS
    Route::resource('scripts', ScriptController::class)->except(['show', 'update']); // Exclude default update route
    Route::get('scripts/scripts', [ScriptController::class, 'scripts'])->name('scripts.scripts');
    Route::post('scripts/update/order', [ScriptController::class, 'updateOrder'])->name('scripts.updateOrder');
    Route::post('scripts/{script}', [ScriptController::class, 'update'])->name('scripts.update');

    // FAQS
    Route::resource('faq', FaqController::class)->except(['show', 'create', 'edit']);
    Route::get('faq/faqs', [FaqController::class, 'faqs'])->name('faq.faqs');
    Route::post('faq/update/order', [FaqController::class, 'updateOrder'])->name('faq.updateOrder');
});
