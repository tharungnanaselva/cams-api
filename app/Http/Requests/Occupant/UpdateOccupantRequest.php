<?php

namespace App\Http\Requests\Occupant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOccupantRequest extends FormRequest
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
                'sometimes',
                'string',
                'max:255'
            ],

            'email' => [
                'sometimes',
                'email',
                Rule::unique('occupants')
                    ->ignore(
                        $this->route('occupant')->id
                    )
            ],

            'phone' => [
                'sometimes',
                'string',
                'max:20'
            ],

            'gender' => [
                'sometimes',
                'in:male,female'
            ],

            'occupant_type' => [
                'sometimes',
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
