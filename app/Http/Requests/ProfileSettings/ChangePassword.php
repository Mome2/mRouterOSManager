<?php

namespace App\Http\Requests\ProfileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;



class ChangePassword extends FormRequest
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
        return [
            'old_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'max:25', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&_]/', 'confirmed', 'different:old_password'],
        ];
    }

    /**
     * Custom message if unauthorized
     */
    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('You are not allowed to change this profile Password.');
    }

    public function messages(): array
    {
        return [
            'old_password.required' => __('attribute.required', ['attribute' => 'old password']),
            'old_password.current_password' => __('current_password'),
            'new_password.required' => __('attribute.required', ['attribute' => 'new password']),
        ];
    }
}
