<?php

use Illuminate\Support\Facades\Route;

// --- Import All Necessary Controllers ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;
// --- Import Admin Controllers with Aliases ---
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController; // <-- THIS IS THE NEW, CRUCIAL LINE

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public-Facing Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// --- Like/Unlike Route ---
Route::post('/videos/{video}/like', [LikeController::class, 'toggle'])->name('videos.like')->middleware('auth');


// --- Standard Authentication Routes ---
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- Admin Routes ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('videos', AdminVideoController::class);
    // --- THIS LINE IS NOW CORRECTED ---
    // It now correctly uses the aliased AdminCategoryController
    Route::resource('categories', AdminCategoryController::class);
});


// --- Include Breeze's Auth Routes (login, register, etc.) ---
require __DIR__.'/auth.php';