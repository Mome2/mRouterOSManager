<?php

namespace App\Http\Requests\TRoles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditRole extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return Auth::user()->can('edit_role');
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
         'id' => 'required|integer|exists:roles,id',
         'name' => 'nullable|string|max:100|unique:roles,name' . $this->input('id'),
         'slug' => 'nullable|string|max:100|unique:roles,slug' . $this->input('id'),
         'description' => 'nullable|string|max:255',
      ];
   }
}
