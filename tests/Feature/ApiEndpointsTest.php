<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_pet_index_endpoint_returns_json(): void
    {
        $user = User::factory()->create();
        Pet::create([
            'user_id' => $user->id,
            'name' => 'Milo',
            'species' => 'Cat',
            'breed' => 'Persia',
            'gender' => 'male',
            'age' => 2,
            'weight' => 3.5,
            'notes' => 'Loyal pet',
        ]);

        $response = $this->getJson('/api/pets');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'name', 'species', 'user']
                ],
            ]);
    }

    public function test_service_store_endpoint_creates_resource(): void
    {
        $payload = [
            'name' => 'Grooming',
            'category' => 'spa',
            'price' => 50000,
            'duration_minutes' => 60,
            'description' => 'Test service',
            'is_active' => true,
        ];

        $response = $this->postJson('/api/services', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Grooming');

        $this->assertDatabaseHas('services', ['name' => 'Grooming']);
    }

    public function test_booking_index_endpoint_returns_json(): void
    {
        $user = User::factory()->create();
        $pet = Pet::create([
            'user_id' => $user->id,
            'name' => 'Coco',
            'species' => 'Dog',
            'breed' => 'Labrador',
            'gender' => 'female',
            'age' => 1,
            'weight' => 6.2,
        ]);
        $service = Service::create([
            'name' => 'Pet Care',
            'category' => 'care',
            'price' => 75000,
            'duration_minutes' => 45,
            'description' => 'Care',
            'is_active' => true,
        ]);

        Booking::create([
            'user_id' => $user->id,
            'pet_id' => $pet->id,
            'service_id' => $service->id,
            'booking_code' => 'BK-TEST01',
            'booking_date' => now()->toDateString(),
            'time_slot' => '10:00',
            'status' => 'pending',
            'total_price' => 75000,
            'notes' => 'Test booking',
        ]);

        $response = $this->getJson('/api/bookings');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'booking_code', 'status']
                ],
            ]);
    }
}
