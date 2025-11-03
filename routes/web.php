<?php

use Illuminate\Support\Facades\Route;

// --- Import All Necessary Controllers ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\VideoController; // Public-facing controller
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController; // <-- THIS LINE IS CRUCIAL. It defines the alias.

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public-Facing Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');

// --- Like/Unlike Route ---
Route::post('/videos/{video}/like', [LikeController::class, 'toggle'])->name('videos.like')->middleware('auth');


// --- Standard Authentication Routes (from Laravel Breeze) ---
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
    // --- THIS LINE IS NOW CORRECT ---
    // It correctly uses the aliased AdminVideoController
    Route::resource('videos', AdminVideoController::class);
    Route::resource('categories', CategoryController::class);
});


// --- Include Breeze's Auth Routes (login, register, etc.) ---
require __DIR__.'/auth.php';