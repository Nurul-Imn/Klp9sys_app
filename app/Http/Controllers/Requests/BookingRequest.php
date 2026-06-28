<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'pet_id' => ['required', 'integer', 'exists:pets,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
