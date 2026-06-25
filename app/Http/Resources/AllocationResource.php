<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllocationResource extends JsonResource
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
            'room' => [
                'id' => $this->room->id,
                'room_number' => $this->room->room_number,
                'room_type' => [
                    'value' => $this->room->room_type,
                    'label' => ucwords(str_replace('_', ' ', $this->room->room_type)),
                ],
                'capacity' => $this->room->capacity,
                'gender_restriction' => [
                    'value' => $this->room->gender_restriction,
                    'label' => ucwords($this->room->gender_restriction),
                ],
                'status' => [
                    'value' => $this->room->status,
                    'label' => ucwords($this->room->status),
                ],
                'building_id' => $this->room->building_id,
                'building' => $this->room->building?->name
            ],
            'occupant' => [
                'id' => $this->occupant->id,
                'name' => $this->occupant->name,
                'gender' => [
                    'value' => $this->occupant->gender,
                    'label' => ucwords($this->occupant->gender),
                ],
                'occupant_type' => [
                    'value' => $this->occupant->occupant_type,
                    'label' => ucwords(str_replace('_', ' ', $this->occupant->occupant_type)),
                ],
            ],
            'allocated_at' => $this->allocated_at,
            'status' => $this->status
        ];
    }
}
