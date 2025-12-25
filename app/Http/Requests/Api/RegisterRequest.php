<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
                'unique:customers,phone',
            ],
            'backup_phone' => [
                'nullable',
                'string',
                'min:10',
                'max:10',
                'regex:/^(091|092|093|094)\d{7}$/',
                'unique:customers,backup_phone',
            ],
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'nullable|email|unique:customers,email',
            'password'     => 'required|string|min:8|confirmed',
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
            'password.confirmed' => __('Password Confirmation does not match.'),
            'first_name.required' => __('First name is required.'),
            'first_name.string' => __('First name must be string.'),
            'first_name.max' => __('First name must be string.'),
            'last_name.required' => __('Last name is required.'),
            'last_name.string' => __('Last name must be string.'),
            'last_name.max' => __('Last name must be string.'),
            'email.required' => __('Email is required.'),
            'email.email' => __('Email must be a valid email address.'),
            'email.unique' => __('Email must be unique.'),
            'backup_phone.unique' => __('Phone number must be unique.'),
            'backup_phone.string' => __('Phone number must be string.'),
            'backup_phone.min' => __('Phone number must be 10 digits long.'),
            'backup_phone.max' => __('Phone number must be 10 digits long.'),
        ];
    }
}
