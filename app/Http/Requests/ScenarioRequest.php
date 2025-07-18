<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScenarioRequest extends FormRequest
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
            'duration' => 'required|int|max:255',
            'remark' => 'nullable|string',
            'total_cost' => 'required|numeric|min:0',
            'markup' => 'required|numeric|min:0',
            'final_cost' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'total_cost.required' => 'Please fill manpower table',
            'total_cost.min' => 'Invalid value for Total Cost'
        ];
    }
}
