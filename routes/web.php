<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Is2FA;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsActive;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Authentication\RegController;
use App\Http\Controllers\Authorization\RoleController;
use App\Http\Controllers\Authorization\PermissionController;
use App\Http\Controllers\Authorization\UserRoleController;
use App\Http\Controllers\Authorization\RolePermissionController;
use App\Http\Controllers\Settings\UserSettingsController;

Route::get('/', function () {
  return view('welcome');
});

/*
 * Guest middleware routes
 */
Route::middleware('guest')->group(function () {

  // Banned user route
  Route::view('auth/banned', 'banned')->name('banned');

  // Login routes
  Route::get('auth/login', [AuthController::class, 'show'])->name('login');
  Route::post('auth/login', [AuthController::class, 'login']);

  // Register routes
  Route::get('auth/register', [RegController::class, 'show'])->name('register');
  Route::post('auth/register', [RegController::class, 'register']);

  // Forgot password routes
  Route::get('forgot-password', [UserSettingsController::class, 'showForgotPassword'])
    ->name('password.request');
  Route::post('forgot-password', [UserSettingsController::class, 'sendResetLink'])
    ->name('password.email');

  // Reset password routes
  Route::get('reset-password/{token}', [UserSettingsController::class, 'showResetPassword'])
    ->name('password.reset');
  Route::post('reset-password', [UserSettingsController::class, 'resetPassword'])
    ->name('password.update');
});

/*
 * Auth middleware routes
 */
Route::middleware(['auth', IsActive::class])->group(function () {

  // 2FA verify routes
  Route::get('auth/tfaverify', [AuthController::class, 'show2FA'])
    ->name('TFAVerify');
  Route::post('auth/tfaverify', [AuthController::class, 'verify2FA']);

  // Email verification routes
  Route::prefix('verify-email')->name('verification.')->group(function () {
    // Verification notice
    Route::get('/', [UserSettingsController::class, 'showVerificationNotice'])
      ->name('notice');
    // Verify email
    Route::get('{id}/{hash}', [UserSettingsController::class, 'verifyEmail'])
      ->middleware(['signed', 'throttle:3,1'])
      ->name('verify');
    // Resend verification email
    Route::post('/', [UserSettingsController::class, 'resendVerificationEmail'])
      ->middleware(['throttle:3,1'])
      ->name('resend');
  });

  // Confirm password route
  Route::post('password/confirm', [UserSettingsController::class, 'confirmPassword'])
    ->name('password.confirm');

  // Logout route
  Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

  // App Routes
  Route::middleware(['verified', Is2FA::class])->group(function () {

    require __DIR__ . '/app-routes.php';
    // Dashboard routes
    Route::prefix('dashboard')->group(function () {
      // Home route
      Route::get('home', [DashboardController::class, 'home'])->name('home');

      // Super admin routes
      Route::middleware(IsAdmin::class)->name('Super.')->group(function () {

        // Users Managing routes
        Route::get('users', [UserController::class, 'index'])->name('index.users');
        Route::post('users', [UserController::class, 'store'])->name('store.user');
        Route::post('users/restore', [UserController::class, 'restore'])
          ->name('restore.user');
        Route::delete('users/forceDelete', [UserController::class, 'forceDelete'])
          ->name('forceDelete.user');
        Route::post('users/sync-uesr-roles', [UserRoleController::class, 'assign'])
          ->name('sync.user-roles');
        Route::delete('users/detach-user-roles', [UserRoleController::class, 'remove'])
          ->name('detach.user-roles');

        // Roles resource routes
        Route::resource('roles', RoleController::class);
        Route::post('roles/restore', [RoleController::class, 'restore'])
          ->name('restore.role');
        Route::delete('roles/forceDelete', [RoleController::class, 'forceDelete'])
          ->name('forceDelete.role');
        Route::post('roles/prem/sync', [RolePermissionController::class, 'assign'])
          ->name('sync.role-permissions');
        Route::delete('roles/prem/detach', [RolePermissionController::class, 'remove'])
          ->name('detach.roles-permissions');

        // Permissions resource routes
        Route::resource('permissions', PermissionController::class);
        Route::post('permissions/restore', [PermissionController::class, 'restore'])
          ->name('restore.permission');
        Route::delete('permissions/forceDelete', [PermissionController::class, 'forceDelete'])
          ->name('forceDelete.permission');
      });

      // Profile settings routes
      Route::prefix('user/settings')->name('user.')->group(function () {
        // Profile route
        Route::get('{user}', [UserController::class, 'show'])->name('settings');
        // Change avatar route
        Route::patch('Avatar', [UserSettingsController::class, 'changeAvatar'])
          ->name('change.avatar');
        // Change name route
        Route::patch('Name', [UserSettingsController::class, 'changeName'])
          ->name('change.name');
        // Change surname route
        Route::patch('Surname', [UserSettingsController::class, 'changeSurname'])
          ->name('change.surname');
        // Change username route
        Route::patch('Username', [UserSettingsController::class, 'changeUsername'])
          ->name('change.username');
        // Change email route
        Route::patch('Email', [UserSettingsController::class, 'changeEmail'])
          ->name('change.email');
        // Change phone route
        Route::patch('Phone', [UserSettingsController::class, 'changePhone'])
          ->name('change.phone');
        // Change 2FA route
        Route::patch('2FA', [UserSettingsController::class, 'change2FA'])
          ->name('change.2fa');
        // Change locale route
        Route::patch('Locale', [UserSettingsController::class, 'changeLocale'])
          ->name('change.locale');
        // Change password route
        Route::patch('Password', [UserSettingsController::class, 'changePassword'])
          ->name('change.password');
        // Change status route
        Route::patch('Status', [UserSettingsController::class, 'changeStatus'])
          ->name('change.status');
        // Delete account route
        Route::delete('{user}', [UserController::class, 'destroy'])->name('delete');
      });
    });
  });
});
