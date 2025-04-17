<?php

namespace App\Http\Requests\TPermissions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddPermission extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return Auth::user()->can('add_permission');
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
         'name' => 'required|string|max:100|unique:permissions,name',
         'slug' => 'required|string|max:100|unique:permissions,slug',
         'group' => 'nullable|string|max:50',
         'description' => 'nullable|string|max:255',
         'role_id' => 'required|integer|exists:roles,id',
      ];
   }
}
