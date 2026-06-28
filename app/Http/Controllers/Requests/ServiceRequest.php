<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $required = $this->isMethod('post') ? 'required' : 'sometimes';

        return [
            'name' => [$required, 'string', 'max:255'],
            'category' => [$required, 'string', 'max:100'],
            'price' => [$required, 'numeric', 'min:0'],
            'duration_minutes' => ['sometimes', 'integer', 'min:1'],
            'daily_slot_capacity' => ['sometimes', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
