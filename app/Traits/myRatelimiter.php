<?php

namespace App\Traits;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;


trait myRatelimiter
{

  public function hasTooManyAttempts()
  {
    return $this->limiter()
      ->tooManyAttempts(
        $this->throttleKey(),
        $this->maxAttempts()
      );
  }

  public function incrementAttempts()
  {
    $this->limiter()->hit(
      $this->throttleKey(),
      $this->decayMinutes() * 60
    );
  }

  public function remainAttempts()
  {
    return $this->limiter()
      ->retriesLeft($this->throttleKey(), $this->maxAttempts());
  }

  public function retryAfter()
  {
    return $this->limiter()
      ->availableIn($this->throttleKey());
  }

  public function clearAttempts()
  {
    $this->limiter()
      ->clear($this->throttleKey());
  }

  public function fireLockoutEvent()
  {
    event(new Lockout($this));
  }

  protected function limiter()
  {
    return app(RateLimiter::class);
  }

  protected function maxAttempts()
  {
    return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
  }

  protected function decayMinutes()
  {
    return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 5;
  }
}
