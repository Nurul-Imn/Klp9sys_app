<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class PaymentApiTest extends TestCase
{
    public function test_payment_webhook_route_is_available(): void
    {
        $response = $this->postJson('/api/v1/payments/webhook', []);

        $response->assertStatus(400);
    }
}
