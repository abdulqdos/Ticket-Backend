<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:10',
                'regex:/^(091|092|093|094)\d{7}$/',
            ],
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => __('Phone number is required'),
            'phone.regex' => __('Phone number must start with 091, 092, 093, or 094 and be 10 digits long.'),
            'phone.min' => __('Phone number must be 10 digits long.'),
            'phone.max' => __('Phone number must be 10 digits long.'),
            'password.required' => __('Password is required.'),
            'password.min' => __('Password must be 8 digits long.'),
            'password.max' => __('Password must be 8 digits long.'),
        ];
    }
}
