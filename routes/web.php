<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\Is2FA;
use App\Http\Middleware\IsActive;

Route::get('/', function () {
   return view('welcome');
});

/*
 * Guest middleware routes
 */
Route::middleware('guest')->group(function () {

   // Banned user route
   Route::get('auth/banned', function () {})->name('banned');

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
Route::middleware(['auth', IsActive::class])->group(function () {

   // 2FA verify routes
   Route::get('auth/tfaverify', function () {})->name('TFAVerify');
   Route::post('auth/tfaverify', function () {});

   // Email verification routes
   Route::prefix('verify-email')->name('verification.')->group(function () {
      // Verification notice
      Route::get('/', function () {})->name('notice');
      // Verify email
      Route::get('{id}/{hash}', function () {})->middleware(['signed', 'throttle:3,1'])->name('verify');
      // Resend verification email
      Route::post('/', function () {})->middleware(['throttle:3,1'])->name('resend');
   });

   // Confirm password route
   Route::post('password/confirm', function () {})->name('password.confirm');

   // Logout route
   Route::post('auth/logout', function () {})->name('logout');

   // 2FA routes
   Route::middleware(['verified', Is2FA::class])->group(function () {
      // Dashboard routes
      Route::prefix('dashboard')->group(function () {
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
         // Super admin routes
         Route::middleware(IsAdmin::class)->name('Super.')->group(function () {

            // Users Managing routes
            Route::get('users', function () {})->name('index.users');
            Route::get('users/{user}', function () {})->name('show.user');
            Route::post('users', function () {})->name('store.user');
            Route::delete('users/delete', function () {})->name('delete.user');
            Route::post('users/restore', function () {})->name('restore.user');
            Route::delete('users/forceDelete', function () {})->name('forceDelete.user');
            Route::post('users/sync-uesr-roles', function () {})->name('sync-user-roles');
            Route::delete('users/detach-user-roles', function () {})->name('detach-user-roles');

            // Roles resource routes
            Route::resource('roles', RoleController::class);
            Route::post('roles/restore', function () {})->name('restore.role');
            Route::delete('roles/forceDelete', function () {})->name('forceDelete.role');
            Route::post('roles/sync-role-permissions', function () {})->name('sync-role-permissions');
            Route::delete('roles/detach-role-permissions', function () {})->name('detach-roles-permissions');

            // Permissions resource routes
            Route::resource('permissions', PermissionController::class);
            Route::post('permissions/restore', function () {})->name('restore.permission');
            Route::delete('permissions/forceDelete', function () {})->name('forceDelete.permission');
         });
      });
   });
});
