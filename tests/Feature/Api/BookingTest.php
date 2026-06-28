<?php

namespace Tests\Feature\Api;

use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_a_reservation(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create();
        $service = Service::factory()->create(['daily_slot_capacity' => 2]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/reservations', [
            'service_id' => $service->id,
            'pet_id' => $pet->id,
            'booking_date' => now()->addDay()->toDateString(),
            'time_slot' => '09:00-10:00',
        ]);

        $response->assertCreated()->assertJsonPath('status', 'success');

        $this->assertDatabaseHas('bookings', [
            'service_id' => $service->id,
            'pet_id' => $pet->id,
            'status' => 'pending',
        ]);
    }

    public function test_reservation_fails_when_slot_is_fully_booked(): void
    {
        $service = Service::factory()->create(['daily_slot_capacity' => 1]);
        $date = now()->addDay()->toDateString();

        $firstUser = User::factory()->create();
        $firstPet = Pet::factory()->for($firstUser)->create();

        $this->actingAs($firstUser, 'sanctum')->postJson('/api/v1/reservations', [
            'service_id' => $service->id,
            'pet_id' => $firstPet->id,
            'booking_date' => $date,
            'time_slot' => '09:00-10:00',
        ])->assertCreated();

        $secondUser = User::factory()->create();
        $secondPet = Pet::factory()->for($secondUser)->create();

        $response = $this->actingAs($secondUser, 'sanctum')->postJson('/api/v1/reservations', [
            'service_id' => $service->id,
            'pet_id' => $secondPet->id,
            'booking_date' => $date,
            'time_slot' => '09:00-10:00',
        ]);

        $response->assertStatus(422)->assertJsonPath('status', 'error');
    }

    public function test_customer_cannot_view_other_users_reservation(): void
    {
        $owner = User::factory()->create();
        $pet = Pet::factory()->for($owner)->create();
        $service = Service::factory()->create();

        $booking = $this->actingAs($owner, 'sanctum')->postJson('/api/v1/reservations', [
            'service_id' => $service->id,
            'pet_id' => $pet->id,
            'booking_date' => now()->addDay()->toDateString(),
            'time_slot' => '10:00-11:00',
        ])->json('data.reservation_id');

        $bookingId = \App\Models\Booking::where('booking_code', $booking)->first()->id;

        $stranger = User::factory()->create();

        $this->actingAs($stranger, 'sanctum')
            ->getJson("/api/v1/reservations/{$bookingId}")
            ->assertStatus(403);
    }
}
