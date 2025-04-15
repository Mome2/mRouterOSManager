<?php

namespace App\Http\Requests\ProfileSettings;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetLink extends FormRequest
{
    protected $redirect = '/error';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:password_reset_tokens,email',
            'token' => 'required'
        ];
    }
    protected function prepareForValidation(): void
    {
        /** @var \Illuminate\Http\Request $this */
        $this->merge([
            'token' => $this->route('token'),
        ]);
    }
}
