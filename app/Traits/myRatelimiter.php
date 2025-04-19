<?php

namespace App\Traits;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


trait myRatelimiter
{

  protected function hasTooManyAttempts(array $keys)
  {
    return $this->limiter()
      ->tooManyAttempts(
        $this->throttleKey($keys),
        $this->maxAttempts()
      );
  }

  protected function incrementAttempts(array $keys)
  {
    $this->limiter()->hit(
      $this->throttleKey($keys),
      $this->decayMinutes() * 60
    );
  }

  protected function remainAttempts(array $keys)
  {
    return $this->limiter()
      ->retriesLeft($this->throttleKey($keys), $this->maxAttempts());
  }

  protected function retryAfter(array $keys)
  {
    return $this->limiter()
      ->availableIn($this->throttleKey($keys));
  }

  protected function clearAttempts(array $keys)
  {
    $this->limiter()
      ->clear($this->throttleKey($keys));
  }

  protected function fireLockoutEvent(Request $request)
  {
    event(new Lockout($request));
  }

  protected function limiter()
  {
    return app(RateLimiter::class);
  }

  protected function throttleKey(array $keys)
  {
    return Str::transliterate(Str::lower(implode('|', $keys)));
  }

  public function maxAttempts()
  {
    return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
  }

  public function decayMinutes()
  {
    return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 5;
  }
}
