<?php

namespace App\Http\Requests\ProfileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeLocale extends FormRequest
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
            'locale' => ['required', 'in:en,ar'], // You can add more supported locales here
        ];
    }

    /**
     * Custom message if unauthorized
     */
    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('You are not allowed to change this profile language.');
    }
    public function messages(): array
    {
        return [
            'locale.required' => __('attribute.required', ['attribute' => 'locale']),
            'locale.in' => __('locales', ['locales' => 'en,ar']),
        ];
    }
}
