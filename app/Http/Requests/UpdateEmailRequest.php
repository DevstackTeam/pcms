<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
         return $this->user()->hasRole('admin');
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
}
