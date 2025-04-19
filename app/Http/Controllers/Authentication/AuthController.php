<?php

namespace App\Http\Controllers\Authentication;

use App\Traits\myRatelimiter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLogin;

class AuthController extends Controller
{
  use myRatelimiter;
  public function login(UserLogin $request)
  {
    /** @var illuminate\Http\Request $request */
    $loginby = $request->session()->get('loginby');
    $maxAttempts = 3;
    $decayMinutes = 10;
    $keys = [
      'identity' => $request->input($loginby),
      'ip' => $request->ip()
    ];


    // use Ratelimiter technique


  }
}
