<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\BlogImageController;

// Serve images from storage (blog, products, etc.)
Route::get('/storage-image/{path}', [BlogImageController::class, 'show'])
    ->where('path', '.*')
    ->name('storage.image.serve');
Route::get('/blog-image/{path}', [BlogImageController::class, 'show'])->where('path', '.*')->name('blog.image.serve'); // backward compat

// Route::get('/', function () {
//     return view('admin.dashboard');
// })->middleware('auth');

Route::get('/', function () {
    $heroSlides = \App\Models\HeroSlide::active()->ordered()->get();
    $blogPosts = \App\Models\BlogPost::published()->with('author')->latest('published_at')->take(6)->get();
    $products = \App\Models\Product::active()->with('images')->latest()->take(8)->get();
    $testimonials = \App\Models\Review::approved()
        ->featured()
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();
    $teamMembers = \App\Models\TeamMember::active()->ordered()->get();
    return view('frontend.pages.index', compact('heroSlides', 'blogPosts', 'products', 'testimonials', 'teamMembers'));
})->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('frontend.blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('frontend.blog.show');

Route::get('/ewaste/request', [\App\Http\Controllers\Frontend\EwasteRequestController::class, 'create'])->name('frontend.ewaste.request');
Route::post('/ewaste', [\App\Http\Controllers\Frontend\EwasteRequestController::class, 'store'])->name('frontend.ewaste.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'check.user.active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::put('users/{user}/change-password', [UserController::class, 'updatePassword'])->name('users.update-password');
});

// مسار toggle-status بدون middleware check.user.active
Route::middleware(['auth'])->group(function () {
    Route::post('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

// مسار بديل للتجربة
Route::post('toggle-user-status/{id}', [UserController::class, 'toggleStatus'])->name('users.toggle-status-alt');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';