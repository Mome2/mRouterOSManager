<?php

namespace App\Http\Requests\Auth;

use App\Traits\myRatelimiter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class UserLogin extends FormRequest
{
  use myRatelimiter;

  protected int $maxAttempts = 3;
  protected int $decayMinutes = 10;

  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'identity' => ['required'],
      'email' => ['sometimes', 'email', 'exists:users,email', 'max:100'],
      'phone' => ['sometimes', 'string', 'exists:users,phone', 'max:15'],
      'username' => ['sometimes', 'string', 'exists:users,username', 'max:100'],
      'password' => ['required', 'string', 'min:8', 'max:25', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&_]/'],
      'remember' => ['boolean']
    ];
  }

  protected function prepareForValidation(): void
  {
    /** @var \Illuminate\Http\Request $this */
    if (filter_var($this->input('identity'), FILTER_VALIDATE_EMAIL)) {
      $this->merge(['email' => $this->input('identity')]);
    } elseif (preg_match('/^01\d{9}$/', $this->input('identity'))) {
      $this->merge(['phone' => $this->input('identity')]);
    } else {
      $this->merge(['username' => $this->input('identity')]);
    }
  }
  protected function throttleKey()
  {
    /** @var \Illuminate\Http\Request $this */
    return Str::transliterate(
      Str::lower(
        implode('|', ['login', $this->input('identity'), $this->ip()])
      )
    );
  }
}
