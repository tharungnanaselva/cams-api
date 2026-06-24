<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
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
            'type' => [
                'value' => $this->type,
                'label' => ucwords(str_replace('_', ' ', $this->type)),
            ],

            'gender_restriction' => [
                'value' => $this->gender_restriction,
                'label' => ucwords($this->gender_restriction),
            ],
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
