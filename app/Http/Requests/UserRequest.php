<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyPermission(['Create User', 'Update User']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],

            'email' => [
                'required', 
                'email', 
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],

            'username' => [
                'required', 
                'string',
                Rule::unique('users', 'username')->ignore($this->route('user')),
            ],
            
            'password' => $this->isMethod('post') ? ['required'] : ['nullable'],
            'roles' => ['array', 'min:1'],
            'roles.*' => ['exists:roles,name'],
        ];
    }
}
