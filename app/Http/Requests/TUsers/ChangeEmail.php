<?php

namespace App\Http\Requests\TUsers;

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
        return $this->user()->is(Auth::user());
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
            'email' => 'required|string|email|max:100|unique:users,email,' . $this->user()->id,
            'password' => 'required|current_password',
        ];
    }
}
