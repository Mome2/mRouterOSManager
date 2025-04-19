<?php

namespace App\Http\Requests\TUsers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddUser extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return Auth::user()->can('add_user');
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
         'name' => 'required|string|max:100',
         'surname' => 'required|string|max:100',
         'username' => 'required|string|max:100|unique:users,username',
         'email' => 'required|string|email|max:100|unique:users,email',
         'phone' => 'required|string|max:15',
      ];
   }
}
