<?php

namespace App\Http\Requests\Occupant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOccupantRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:occupants,email'
            ],

            'phone' => [
                'required',
                'string',
                'max:20'
            ],

            'gender' => [
                'required',
                'in:male,female'
            ],

            'occupant_type' => [
                'required',
                'in:student,employee,guest'
            ],

            'department' => [
                'nullable',
                'string',
                'max:255'
            ]
        ];
    }
}
