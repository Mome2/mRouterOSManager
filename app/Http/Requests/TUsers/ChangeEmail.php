<?php

namespace App\Http\Requests\TUsers;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeEmail extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      /** @var \Illuminate\Http\Request $this */
      return strtolower(trim($this->input('old_email'))) === strtolower(Auth::user()->email);
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
   public function rules(): array
   {
      /** @var \Illuminate\Http\Request $this */
      return [
         //
         'old_email' => 'required|string|email|max:100|exist:users,email',
         'new_email' => 'required|string|email|max:100|unique:users,email,' . Auth::user()->id,
         'password' => 'required|current_password',
      ];
   }
}
