<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->price,
            'duration_minutes' => $this->duration_minutes,
            'daily_slot_capacity' => $this->daily_slot_capacity,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }
}
