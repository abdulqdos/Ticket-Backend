<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        $userId = $this->user()->id;

        return [
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:10',
                'regex:/^(091|092|093|094)\d{7}$/',
                'unique:customers,phone,' . $userId
            ],

            'backup_phone' => [
                'nullable' ,
                'string'  ,
                'min:10' ,
                'max:10' ,
                'regex:/^(091|092|093|094)\d{7}$/',
                'unique:customers,backup_phone,' . $userId
            ],
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'nullable|email|unique:customers,email,' . $userId,
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
