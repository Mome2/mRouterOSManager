<?php

namespace App\Http\Requests\ProfileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeName extends FormRequest
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
            'name' => 'required|string|max:100',
        ];
    }

    /**
     * Custom message if unauthorized
     */
    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('You are not allowed to change this profile name.');
    }
    public function messages(): array
    {
        return [
            'name.required' => __('attribute.required', ['attribute' => 'name']),
            'name.string' => __('attribute.string', ['attribute' => 'name']),
            'name.max' => __('attribute.max', ['attribute' => 'name', 'max' => 100]),
        ];
    }
}
