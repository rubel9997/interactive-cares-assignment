<?php

use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::post('login', LoginController::class);
Route::post('logout', LogoutController::class);
Route::post('register', RegisterController::class);
Route::post('password/email', [PasswordResetController::class,'sendResetLinkEmail'])->name('password.email');
Route::post('password/reset', [PasswordResetController::class,'reset'])->middleware('signed')->name('password.reset');
Route::post('email/verify/send', [EmailVerificationController::class,'sendEmail'])->name('verify.send');
Route::post('email/verify', [EmailVerificationController::class,'verifyEmail'])->middleware('signed')->name('email.verify');

