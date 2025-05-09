<?php

namespace App\Http\Requests\ProfileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Change2FA extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      /** @var \Illuminate\Http\Request $this */
      $targetUserId = $this->input('id');
      return (int) $targetUserId === Auth::id();
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
   public function rules(): array
   {
      return [
         'id' => 'required|exists:users,id',
         'two_factor_enabled' => ['required', 'in:true,false'],
      ];
   }
   public function failedAuthorization()
   {
      throw new \Illuminate\Auth\Access\AuthorizationException('You are not allowed to modify 2FA for this user.');
   }
   public function messages(): array
   {
      return [
         'two_factor_enabled.required' => __('attribute.required', ['attribute' => 'two_factor_enabled']),
         'two_factor_enabled.in' => __('enable-or-disable'),
      ];
   }
}
