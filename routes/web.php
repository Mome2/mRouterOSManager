<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\Is2FA;

$pagination = 10;

/*
 * Index route
 */
Route::get('/', function () {
   return view('welcome');
});

/*
 * Guest middleware routes
 */
Route::middleware('guest')->group(function () {

   // Login routes
   Route::get('auth/login', function () {})->name('login');
   Route::post('auth/login', function () {});

   // Register routes
   Route::get('auth/register', function () {})->name('register');
   Route::post('auth/register', function () {});

   // Forgot password routes
   Route::get('forgot-password', function () {})->name('password.request');
   Route::post('forgot-password', function () {})->name('password.email');

   // Reset password routes
   Route::get('reset-password/{token}', function () {})->name('password.reset');
   Route::post('reset-password', function () {})->name('password.update');
});

/*
 * Auth middleware routes
 */
Route::middleware(['auth'])->group(function () {

   // 2FA verify route
   Route::get('auth/TFAVerify', function () {})->name('TFAVerify');
   Route::post('auth/TFAVerify', function () {});

   // Email verification routes
   Route::prefix('verify-email')->name('verification.')->group(function () {
      // Verification notice
      Route::get('/', function () {})->name('notice');
      // Verify email
      Route::get('{id}/{hash}', function () {})->middleware(['signed', 'throttle:6,1'])->name('verify');
      // Resend verification email
      Route::post('/', function () {})->middleware(['throttle:6,1'])->name('resend');
   });

   // Confirm password route
   Route::post('password/confirm', function () {})->name('password.confirm');

   // Logout route
   Route::post('auth/logout', function () {})->name('logout');

   // Dashboard routes
   Route::prefix('dashboard')->middleware(Is2FA::class)->group(function () {
      // Home route
      Route::get('home', function () {})->name('home');

      // Profile settings routes
      Route::prefix('profile/settings')->name('profile.')->group(function () {
         // Profile route
         Route::get('/', function () {})->name('settings');
         // Change 2FA route
         Route::patch('change/2FA', function () {})->name('change.2fa');
         // Change avatar route
         Route::patch('change/Avatar', function () {})->name('change.avatar');
         // Change locale route
         Route::patch('change/Locale', function () {})->name('change.locale');
         // Change password route
         Route::patch('change/Password', function () {})->name('change.password');
         // Change status route
         Route::patch('change/Status', function () {})->name('change.status');
         // Delete account route
         Route::delete('delete', function () {})->name('delete');
      });
   });

   // Super admin routes
   Route::prefix('Super/dashboard')->middleware(IsAdmin::class)->name('Super.')->group(function () {

      // Home route
      Route::get('home', function () {})->name('home');

      // Users Managing routes
      Route::get('users/create', function () {})->name('create.user');
      Route::post('users', function () {})->name('store.user');
      Route::patch('users/{user}/status', function () {})->name('change.user.status');
      Route::delete('users/{user}', function () {})->name('delete.user');

      // Roles resource routes
      Route::resource('roles', RoleController::class);

      // Permissions resource routes
      Route::resource('permissions', PermissionController::class);
   });
});
