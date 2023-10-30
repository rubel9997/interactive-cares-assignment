<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
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

//Route::get('/', function () {
//    return view('auth.login');
//});


//Route::get('/admin',function (){
//    dd('Hello world.This is admin panel');
//})->middleware('auth');


//Dashboard route
//Route::get('/login',[LoginController::class,'loginForm']);
Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');

//login and register route
Route::get('/',[LoginController::class,'loginForm'])->name('login-form');
Route::post('login',[LoginController::class,'login'])->name('login');
Route::post('logout',[LoginController::class,'logout'])->name('logout');
Route::get('register-from',[RegisterController::class,'registerForm'])->name('register-form');
Route::post('register',[RegisterController::class,'register'])->name('register');

//user route
Route::get('user-profile',[UserController::class,'profile'])->name('profile');
Route::get('user-profile-edit',[UserController::class,'edit'])->name('edit.profile');
Route::post('user-profile-update',[UserController::class,'update'])->name('update.profile');
