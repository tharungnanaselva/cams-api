<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => [
                'value' => $this->gender,
                'label' => ucwords($this->gender),
            ],
            'occupant_type' => [
                'value' => $this->occupant_type,
                'label' => ucwords(str_replace('_', ' ', $this->occupant_type)),
            ],
            'department' => $this->department,
        ];
    }
}
