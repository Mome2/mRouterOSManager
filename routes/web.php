<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {

    Route::get('login', function () {})->name('login');
    Route::post('login', function () {});

    Route::get('register', function () {})->name('register');
    Route::post('register', function () {});

    Route::get('forgot-password', function () {})->name('password.request');
    Route::post('forgot-password', function () {})->name('password.email');

    Route::get('reset-password/{token}', function () {})->name('password.reset');
    Route::post('reset-password', function () {})->name('password.update');
});
Route::middleware('auth')->group(function () {
    Route::get('User/TFAVerify', function () {})->name('TFAVerify');
    Route::post('User/TFAVerify', function () {});

    Route::get('verify-email', function () {})->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', function () {})->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('verify-email', function () {})->middleware(['throttle:6,1'])->name('verification.resend');

    Route::prefix('profile/settings')->group(function () {});
});
