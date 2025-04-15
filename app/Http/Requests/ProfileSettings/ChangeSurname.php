<?php

namespace App\Http\Requests\ProfileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeSurname extends FormRequest
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
        return [
            'surname' => 'required|string|max:100',
        ];
    }

    /**
     * Custom message if unauthorized
     */
    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('You are not allowed to change this profile surname.');
    }
    public function messages(): array
    {
        return [
            'surname.required' => __('attribute.required', ['attribute' => 'surname']),
            'surname.string' => __('attribute.string', ['attribute' => 'surname']),
            'surname.max' => __('attribute.max', ['attribute' => 'surname', 'max' => 100]),
        ];
    }
}
