<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'building_id' => $this->building_id,
            'building_name' => $this->building?->name,
            'room_number' => $this->room_number,
            'room_type' => [
                'value' => $this->room_type,
                'label' => ucwords(str_replace('_', ' ', $this->room_type)),
            ],
            'capacity' => $this->capacity,
            'gender_restriction' => [
                'value' => $this->gender_restriction,
                'label' => ucwords($this->gender_restriction),
            ],
            'status' => [
                'value' => $this->status,
                'label' => ucwords($this->status),
            ],
        ];
    }
}
