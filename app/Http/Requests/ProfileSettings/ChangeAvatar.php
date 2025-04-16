<?php

namespace App\Http\Requests\ProfileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeAvatar extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var \Illuminate\Http\Request $this */

        // Allow only authenticated users to change their own avatar
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
            'avatar' => [
                'required',
                'image',               // must be an image
                'mimes:jpeg,png,jpg',  // restrict allowed file types
                'max:2048',            // max size in KB (2MB)
            ],
        ];
    }

    /**
     * Custom message if unauthorized
     */
    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('You are not allowed to change this profile picture.');
    }
    public function messages(): array
    {
        return [
            'avatar.required' => __('attribute.required', ['attribute' => 'avatar']),
            'avatar.image' => __('image'),
            'avatar.mimes' => __('mimes', ['mimes' => 'jpeg,png,jpg']),
            'avatar.max' => __('max', ['max' => '2048']),
        ];
    }
}
