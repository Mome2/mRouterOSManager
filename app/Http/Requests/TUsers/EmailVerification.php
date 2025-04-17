<?php

namespace App\Http\Requests\TUsers;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class EmailVerification extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      /** @var illuminate\http\Request $this */
      $targetUser = User::findOrFail($this->route('id'));
      return $targetUser->is(Auth::user());
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
   public function rules(): array
   {
      return [
         'id' => ['required'],
         'hash' => ['required'],
      ];
   }

   protected function prepareForValidation()
   {
      /** @var illuminate\http\Request $this */
      // You can optionally cast these to strings here
      $this->merge([
         'id' => (string) $this->route('id'),
         'hash' => (string) $this->route('hash'),
      ]);
   }

   protected function passedAuthorization(): void
   {
      /** @var illuminate\http\Request $this */
      if (! hash_equals($this->id, (string) Auth::user()->getKey())) {
         throw new AuthorizationException('Invalid user ID.');
      }

      if (! hash_equals($this->hash, sha1(Auth::user()->getEmailForVerification()))) {
         throw new AuthorizationException('Invalid hash.');
      }
   }
}
