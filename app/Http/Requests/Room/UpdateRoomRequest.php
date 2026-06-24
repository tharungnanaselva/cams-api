<?php

namespace App\Http\Requests\Room;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'building_id' => [
                'sometimes',
                'exists:buildings,id'
            ],

            'room_number' => [
                'sometimes',
                'string',
                'max:50'
            ],

            'room_type' => [
                'sometimes',
                'in:single,double,triple,four'
            ],

            'gender_restriction' => [
                'sometimes',
                'in:male,female,mixed'
            ],

            'status' => [
                'sometimes',
                'in:available,occupied,reserved,blocked,maintenance'
            ]
        ];
    }
}
