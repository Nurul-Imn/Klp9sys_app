<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'reservation_id' => $this->booking_code,
            'id' => $this->id,
            'pet' => new PetResource($this->whenLoaded('pet')),
            'pet_name' => $this->whenLoaded('pet', fn () => $this->pet->name),
            'service' => new ServiceResource($this->whenLoaded('service')),
            'reservation_date' => $this->booking_date?->format('Y-m-d'),
            'time_slot' => $this->time_slot,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'notes' => $this->notes,
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'payment_status' => $this->whenLoaded('payment', fn () => $this->payment?->status ?? 'unpaid', 'unpaid'),
        ];
    }
}
