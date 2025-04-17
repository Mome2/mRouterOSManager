<?php

namespace App\Http\Requests\Pivot;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RolePermission extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return Auth::user()->can('assign_permissions');
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
         'role_id' => ['required', 'exists:roles,id'],
         'permission_ids' => ['required', 'array'],
         'permission_ids.*' => ['exists:permissions,id'],
      ];
   }
}
