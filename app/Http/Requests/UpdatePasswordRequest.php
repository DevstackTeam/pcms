<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
         return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed' => 'The new password confirmation does not match.',
        ];
    }
}
