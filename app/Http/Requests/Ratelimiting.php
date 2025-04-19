<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\myRatelimiter;

class Ratelimiting extends FormRequest
{
  use myRatelimiter;

  public function enforceRateLimit(array $keys)
  {
    if ($this->hasTooManyAttempts($keys)) {
      $this->fireLockoutEvent($this);
      abort(429, 'Too many requests.');
    }

    $this->incrementAttempts($keys);
  }
}
