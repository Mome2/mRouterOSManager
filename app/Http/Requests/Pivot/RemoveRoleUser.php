<?php

namespace App\Http\Requests\Pivot;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemoveRoleUser extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return Auth::user()->can('remove_roles');
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
   public function rules(): array
   {
      return [
         //
         'user_id' => ['required', 'exists:users,id'],
         'role_id' => ['required', 'exists:roles,id'],
      ];
   }
}
