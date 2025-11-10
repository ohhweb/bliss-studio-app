<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\ActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// This group protects all our API endpoints, ensuring only authenticated
// users can perform actions like liking, adding to a watchlist, or sending activity data.
Route::middleware('auth:sanctum')->group(function () {
    // Route for liking/unliking a video
    Route::post('/videos/{video}/like', [LikeController::class, 'toggle']);

    // Route for adding/removing a video from the watchlist
    Route::post('/videos/{video}/watchlist', [WatchlistController::class, 'toggle']);
    
    // Route for the device activity heartbeat
    Route::post('/activity/heartbeat', [ActivityController::class, 'heartbeat']);
});