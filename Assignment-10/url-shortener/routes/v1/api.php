<?php


use App\Http\Controllers\Api\V1\UrlController;
use App\Http\Controllers\Api\V1\UserController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::prefix('v1')->group(function(){

    Route::middleware(['auth:sanctum', 'verified','throttle:3000,1'])->group(function (){

        Route::get('user/show', UserController::class)->name('user.show');
        Route::apiResource('urls', UrlController::class);
    });
});

