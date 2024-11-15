<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/admin.php';

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [App\Http\Controllers\Web\AboutUsController::class, 'index'])->name('about-us');
Route::get('/gallery', [App\Http\Controllers\Web\GalleryController::class, 'index'])->name('gallery');
Route::get('/booking', [App\Http\Controllers\Web\BookingController::class, 'index'])->name('booking');
Route::get('/partners', [App\Http\Controllers\Web\PartnersController::class, 'index'])->name('partners');
Route::get('/questions-and-answers', [App\Http\Controllers\Web\FaqController::class, 'index'])->name('faq');
Route::get('/testimonials', [App\Http\Controllers\Web\TestimonialsController::class, 'index'])->name('testimonials');
Route::get('/coverage', [App\Http\Controllers\Web\CoverageController::class, 'index'])->name('coverage');
Route::get('/services', [App\Http\Controllers\Web\ServicesController::class, 'index'])->name('services');
Route::get('/services/{id}/{slug}', [App\Http\Controllers\Web\ServicesController::class, 'show'])->name('services.service');
Route::get('/blogs', [App\Http\Controllers\Web\BlogController::class, 'index'])->name('blogs');
Route::get('/blogs/{id}/{slug}', [App\Http\Controllers\Web\BlogController::class, 'show'])->name('blogs.blog');
Route::get('/contact-us', [App\Http\Controllers\Web\ContactUsController::class, 'index'])->name('contact-us');
