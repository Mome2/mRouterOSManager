<?php

namespace App\Http\Requests\TUsers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeUsername extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var \Illuminate\Http\Request $this */
        return Auth::check() && $this->user()->is(Auth::user());
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
            'id' => 'required|exists:users,id',
            'password' => 'required|current_password',
            'username' => 'required|string|max:100|unique:users,username,' . $this->user()->id,
        ];
    }
}
