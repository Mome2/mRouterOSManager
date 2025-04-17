<?php

namespace App\Http\Requests\TPermissions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditPermission extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return Auth::user()->can('edit_permission');
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
         'id' => 'required|integer|exists:permissions,id',
         'name' => 'nullable|string|max:100|unique:permissions,name' . $this->input('id'),
         'slug' => 'nullable|string|max:100|unique:permissions,slug' . $this->input('id'),
         'group' => 'nullable|string|max:50',
         'description' => 'nullable|string|max:255',
      ];
   }
}
