<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
         return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->user()->id, // Ignore current user
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'email.unique' => 'The email has already been taken.',
            'email.email' => 'The email must be a valid email address.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if the input email is the same as the current user's
            if ($this->email === $this->user()->email) {
                $validator->errors()->add('email', 'Enter a new email different from your current one.');
            }
        });
    }

}
