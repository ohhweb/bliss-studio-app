<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// // --- Import All Necessary Controllers ---
// // Public & User Controllers
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\VideoController;
// use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\PlanController; 
// use App\Http\Controllers\LikeController;
// use App\Http\Controllers\WatchlistController;
// use App\Http\Controllers\HistoryController;
// use App\Http\Controllers\ActivityController;
// // Admin Controllers
// use App\Http\Controllers\Admin\VideoController as AdminVideoController;
// use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
// use App\Http\Controllers\Admin\DeviceController;
// use App\Http\Controllers\Admin\UserController;  

// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// */

// // --- Public Routes (Visible to Everyone) ---
// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/search', [HomeController::class, 'search'])->name('search');
// Route::get('/search-form', [HomeController::class, 'showSearchForm'])->name('search.form');

// // --- Routes for Blocked Users ---
// Route::get('/blocked', function () {
//     return view('blocked.notice');
// })->name('blocked.notice')->middleware('auth');

// Route::post('/request-unblock', function (Request $request) {
//     $user = $request->user();
//     if ($user->status === 'blocked') {
//         $user->status = 'unblock_request';
//         $user->save();
//         return back()->with('success', 'Your request has been sent to the admin.');
//     }
//     return back();
// })->name('unblock.request')->middleware('auth');


// // --- Routes That Require Login (but not a subscription) ---
// Route::middleware('auth')->group(function() {
    
//     Route::redirect('/dashboard', '/')->name('dashboard');
//     // Plan selection
//     Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
//     Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');

//     // User Interaction Forms (Page Reload Method)
//     Route::post('/videos/{video}/like', [LikeController::class, 'toggle'])->name('videos.like');
//     Route::post('/videos/{video}/watchlist', [WatchlistController::class, 'toggle'])->name('videos.watchlist.toggle');

//     // User Account Pages
//     Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
//     Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     // Device Activity Heartbeat (Web Route)
//     Route::post('/activity/heartbeat', [ActivityController::class, 'heartbeat']);
// });


// // --- Content Routes (Require Login, a Subscription, AND Not Blocked) ---
// Route::middleware(['auth', 'subscribed', 'is_not_blocked'])->group(function () {
//     Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
//     Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
//     Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
// });


// // --- Admin Routes (Require Login AND Admin status) ---
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('videos', AdminVideoController::class);
//     Route::resource('categories', AdminCategoryController::class);
//     Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
//     Route::patch('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
//     Route::patch('/users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
// });


// // --- Default Breeze Auth Routes (login, register, forgot-password, etc.) ---
// require __DIR__.'/auth.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import All Necessary Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanController; 
use App\Http\Controllers\LikeController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes (Visible to Everyone) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-form', [HomeController::class, 'showSearchForm'])->name('search.form');

// --- Routes for Blocked Users ---
Route::middleware('auth', 'is_blocked')->group(function () {
    Route::redirect('/dashboard', '/')->name('dashboard');
    Route::get('/blocked', function () {
        return view('blocked.notice');
    })->name('blocked.notice');

    Route::post('/request-unblock', function (Request $request) {
        $user = $request->user();
        if ($user->status === 'blocked') {
            $user->status = 'unblock_request';
            $user->save();
            return back()->with('success', 'Your request has been sent.');
        }
        return back();
    })->name('unblock.request');
});


// --- Routes That Require Login (but not a subscription) ---
Route::middleware('auth')->group(function() {
    // Plan selection
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');

    // User Interaction Forms
    Route::post('/videos/{video}/like', [LikeController::class, 'toggle'])->name('videos.like');
    Route::post('/videos/{video}/watchlist', [WatchlistController::class, 'toggle'])->name('videos.watchlist.toggle');

    // User Account Pages
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Device Activity Heartbeat
    Route::post('/activity/heartbeat', [ActivityController::class, 'heartbeat']);
});


// --- Content Routes (Require Login, Subscription, AND Not Blocked) ---
Route::middleware(['auth', 'subscribed', 'is_not_blocked'])->group(function () {
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
});


// --- Admin Routes (Require Login AND Admin status) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('videos', AdminVideoController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
    Route::patch('/users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
});

// The auth routes (login, register, etc.) are automatically included by Laravel 11.
// We no longer need to require the auth.php file.
require __DIR__.'/auth.php';