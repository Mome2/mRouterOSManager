<?php

namespace App\Http\Requests\TUsers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeStatus extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      /** @var \Illuminate\Http\Request $this */
      $targetUserId = $this->input('id');

      if (! $targetUserId) {
         return false;
      }

      if ((int) $targetUserId === Auth::id()) {
         return true; // Allow users to change their own status (if that’s acceptable)
      }

      return Auth::user()->can('change_user_status'); // Otherwise require permission
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
         'id' => 'required|exists:users,id',
         'status' => 'required|in:active,inactive',
      ];
   }
}
