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
                'building' => $this->room->building?->name
            ],
            'occupant' => [
                'id' => $this->occupant->id,
                'name' => $this->occupant->name,
                'gender' => $this->occupant->gender
            ],
            'allocated_at' => $this->allocated_at,
            'status' => $this->status
        ];
    }
}
