<?php

use Illuminate\Support\Facades\Route;

// --- Import All Necessary Controllers ---
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\PlanController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HistoryController; // <-- THIS IS THE MISSING LINE
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public-Facing Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-form', [HomeController::class, 'showSearchForm'])->name('search.form');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// --- User Interaction Routes ---
Route::middleware('auth')->group(function() {
    Route::post('/videos/{video}/like', [LikeController::class, 'toggle'])->name('videos.like');
    Route::post('/videos/{video}/watchlist', [WatchlistController::class, 'toggle'])->name('videos.watchlist.toggle');
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});

// --- Standard Authentication Routes ---
Route::get('/dashboard', fn() => redirect()->route('home'))->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Admin Routes ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('videos', AdminVideoController::class);
    Route::resource('categories', AdminCategoryController::class);
    // Inside the admin route group
Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
});

// These routes require a user to be logged in AND have a subscription
Route::middleware(['auth', 'subscribed'])->group(function () {
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
    // ... add any other content routes here, like '/search' if you want to protect it too.
});
Route::get('/plans', [PlanController::class, 'index'])->name('plans.index')->middleware('auth');
Route::post('/plans', [PlanController::class, 'store'])->name('plans.store')->middleware('auth');
require __DIR__.'/auth.php';