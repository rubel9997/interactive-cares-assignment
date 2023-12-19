<?php


use App\Http\Controllers\Api\V2\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('v2')->group(function () {
    Route::middleware(['auth:sanctum', 'verified','throttle:3000,1'])->group(function () {
        Route::get('/visit-count/{shortener_url}', [DashboardController::class, 'visitCount'])->name('visit-count');
    });
});

