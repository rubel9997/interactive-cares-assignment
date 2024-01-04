<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomDashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login')->middleware('guest');

//user route
Route::middleware('auth')->group(function () {

    Route::get('/home', [CustomDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifications', [CustomDashboardController::class, 'allNotification'])->name('notifications.index');
    Route::post('/user/search', [CustomDashboardController::class, 'search'])->name('user.search');

    Route::get('profile/{username}', [UserController::class, 'profile'])->name('profile');
    Route::get('profile-edit', [UserController::class, 'edit'])->name('edit.profile');
    Route::get('password-change', [UserController::class, 'changePassword'])->name('change.password');
    Route::put('password-update', [UserController::class, 'passwordUpdate'])->name('password.update');
    Route::post('profile-update', [UserController::class, 'update'])->name('update.profile');

    Route::post('post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('post/status/{uuid}', [PostController::class, 'singlePostView'])->name('post.single');
    Route::get('post/edit/{uuid}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('post/update', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/delete/{id}', [PostController::class, 'destroy'])->name('post.delete');

    Route::post('react', [ReactController::class, 'react'])->name('post.react');

    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/comment/{post_uuid}/edit/{comment_uuid}', [CommentController::class, 'edit'])->name('comment.edit');
    Route::delete('comment/delete/{comment_id}', [CommentController::class, 'destroy'])->name('comment.delete');

});

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
