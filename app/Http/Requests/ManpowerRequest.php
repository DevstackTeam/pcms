<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManpowerRequest extends FormRequest
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
            'manpower' => 'required|array',
            'manpower.*.designation_id' => 'required|exists:designations,id',
            'manpower.*.rate_per_day' => 'required|numeric|min:0',
            'manpower.*.no_of_people' => 'required|integer|min:0',
            'manpower.*.total_day' => 'required|integer|min:0',
            'manpower.*.total_cost' => 'required|numeric|min:0',
        ];
    }
}
