<?php

use App\Http\Controllers\CustomAuth\LoginController;
use App\Http\Controllers\CustomAuth\RegisterController;
use App\Http\Controllers\CustomDashboardController;
use App\Http\Controllers\PostController;
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


//Dashboard route
Route::get('/dashboard',[CustomDashboardController::class,'dashboard'])->name('dashboard');

//login and register route
Route::get('/',[LoginController::class,'loginForm'])->name('login-form');
Route::post('login',[LoginController::class,'login'])->name('login');
Route::post('logout',[LoginController::class,'logout'])->name('logout');
Route::get('register-from',[RegisterController::class,'registerForm'])->name('register-form');
Route::post('register',[RegisterController::class,'register'])->name('register');

//user route
Route::get('user-profile/{id}',[UserController::class,'profile'])->name('profile');
Route::get('user-profile-edit',[UserController::class,'edit'])->name('edit.profile');
Route::get('user-password-change',[UserController::class,'changePassword'])->name('change.password');
Route::patch('user-password-update',[UserController::class,'passwordUpdate'])->name('password.update');
Route::post('user-profile-update',[UserController::class,'update'])->name('update.profile');

Route::prefix('posts')->group(function (){
        Route::post('/store',[PostController::class,'store'])->name('post.store');
        Route::get('/single/{id}',[PostController::class,'singlePostView'])->name('post.single');
        Route::get('/edit/{uuid}',[PostController::class,'edit'])->name('post.edit');
        Route::put('/update',[PostController::class,'update'])->name('post.update');
        Route::delete('/delete/{id}',[PostController::class,'destroy'])->name('post.delete');
        Route::post('react',[PostController::class,'react'])->name('post.react');
});
