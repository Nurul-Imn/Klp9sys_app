<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_returns_products_and_services(): void
    {
        Product::factory()->create(['name' => 'Premium Cat Food']);
        Service::factory()->create(['name' => 'Cat Grooming Paket Lengkap']);

        $response = $this->getJson('/api/v1/products');

        $response->assertOk()->assertJsonPath('status', 'success');

        $names = collect($response->json('data'))->pluck('name');

        $this->assertTrue($names->contains('Premium Cat Food'));
        $this->assertTrue($names->contains('Cat Grooming Paket Lengkap'));
    }

    public function test_admin_can_create_a_product(): void
    {
        $admin = \App\Models\User::factory()->admin()->create();

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/v1/admin/products', [
            'name' => 'Kitten Food 500g',
            'category' => 'makanan',
            'price' => 45000,
            'stock' => 10,
        ]);

        $response->assertCreated()->assertJsonPath('data.name', 'Kitten Food 500g');
    }

    public function test_customer_cannot_create_a_product(): void
    {
        $customer = \App\Models\User::factory()->create();

        $this->actingAs($customer, 'sanctum')->postJson('/api/v1/admin/products', [
            'name' => 'Kitten Food 500g',
            'category' => 'makanan',
            'price' => 45000,
        ])->assertStatus(403);
    }
}
