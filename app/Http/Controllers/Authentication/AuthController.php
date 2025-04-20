<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLogin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(UserLogin $request)
  {
    /** @var illuminate\Http\Request $request*/
    if ($request->hasTooManyAttempts()) {
      return $request->fireLockoutEvent();
    }
    $creds = $request->only('email', 'phone', 'username', 'password');
    if (Auth::attempt(array_filter($creds), $request->boolean('remember'))) {
    }
  }
}
