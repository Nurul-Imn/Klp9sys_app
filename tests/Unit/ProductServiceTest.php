<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Unit tests untuk ProductService.
 */
class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = new ProductService();
    }

    // ─── Helper ──────────────────────────────────────────────────

    private function createProduct(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'name'        => 'Test Product',
            'category'    => 'makanan',
            'price'       => 50000,
            'stock'       => 10,
            'description' => 'Test description',
            'is_active'   => true,
        ], $overrides));
    }

    // ──────────────────────────────────────────────────────────────
    //  LIST PRODUCTS
    // ──────────────────────────────────────────────────────────────

    /** listProducts() mengembalikan semua produk. */
    public function test_list_products_returns_all_products(): void
    {
        $this->createProduct(['name' => 'Produk A']);
        $this->createProduct(['name' => 'Produk B']);
        $this->createProduct(['name' => 'Produk C']);

        $result = $this->productService->listProducts();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
    }

    /** listProducts() dapat difilter berdasarkan is_active = true. */
    public function test_list_products_filters_by_is_active_true(): void
    {
        $this->createProduct(['name' => 'Aktif', 'is_active' => true]);
        $this->createProduct(['name' => 'Nonaktif', 'is_active' => false]);

        $result = $this->productService->listProducts(['is_active' => true]);

        $this->assertCount(1, $result);
        $this->assertEquals('Aktif', $result[0]['name']);
    }

    /** listProducts() dapat difilter berdasarkan is_active = false. */
    public function test_list_products_filters_by_is_active_false(): void
    {
        $this->createProduct(['name' => 'Aktif', 'is_active' => true]);
        $this->createProduct(['name' => 'Nonaktif', 'is_active' => false]);

        $result = $this->productService->listProducts(['is_active' => false]);

        $this->assertCount(1, $result);
        $this->assertEquals('Nonaktif', $result[0]['name']);
    }

    /** listProducts() dapat difilter berdasarkan category. */
    public function test_list_products_filters_by_category(): void
    {
        $this->createProduct(['name' => 'Makanan A', 'category' => 'makanan']);
        $this->createProduct(['name' => 'Aksesoris A', 'category' => 'aksesoris']);

        $result = $this->productService->listProducts(['category' => 'makanan']);

        $this->assertCount(1, $result);
        $this->assertEquals('Makanan A', $result[0]['name']);
    }

    /** listProducts() dapat difilter berdasarkan min_price. */
    public function test_list_products_filters_by_min_price(): void
    {
        $this->createProduct(['name' => 'Murah', 'price' => 10000]);
        $this->createProduct(['name' => 'Mahal', 'price' => 200000]);

        $result = $this->productService->listProducts(['min_price' => 50000]);

        $this->assertCount(1, $result);
        $this->assertEquals('Mahal', $result[0]['name']);
    }

    /** listProducts() dapat difilter berdasarkan max_price. */
    public function test_list_products_filters_by_max_price(): void
    {
        $this->createProduct(['name' => 'Murah', 'price' => 10000]);
        $this->createProduct(['name' => 'Mahal', 'price' => 200000]);

        $result = $this->productService->listProducts(['max_price' => 50000]);

        $this->assertCount(1, $result);
        $this->assertEquals('Murah', $result[0]['name']);
    }

    /** listProducts() mengembalikan array kosong jika tidak ada produk. */
    public function test_list_products_returns_empty_when_no_products(): void
    {
        $result = $this->productService->listProducts();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  GET PRODUCT
    // ──────────────────────────────────────────────────────────────

    /** getProduct() mengembalikan data produk berdasarkan ID. */
    public function test_get_product_returns_correct_product(): void
    {
        $product = $this->createProduct(['name' => 'Produk Spesifik']);

        $result = $this->productService->getProduct($product->id);

        $this->assertIsArray($result);
        $this->assertEquals($product->id, $result['id']);
        $this->assertEquals('Produk Spesifik', $result['name']);
    }

    /** getProduct() melempar exception untuk produk yang tidak ada. */
    public function test_get_product_throws_exception_for_nonexistent(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->productService->getProduct(99999);
    }

    // ──────────────────────────────────────────────────────────────
    //  CREATE PRODUCT
    // ──────────────────────────────────────────────────────────────

    /** createProduct() membuat produk baru dan mengembalikan datanya. */
    public function test_create_product_creates_and_returns_product(): void
    {
        $data = [
            'name'      => 'Produk Baru',
            'category'  => 'aksesoris',
            'price'     => 85000,
            'stock'     => 20,
            'is_active' => true,
        ];

        $result = $this->productService->createProduct($data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals('Produk Baru', $result['name']);
        $this->assertDatabaseHas('products', ['name' => 'Produk Baru', 'price' => 85000]);
    }

    // ──────────────────────────────────────────────────────────────
    //  UPDATE PRODUCT
    // ──────────────────────────────────────────────────────────────

    /** updateProduct() memperbarui data produk. */
    public function test_update_product_updates_data(): void
    {
        $product = $this->createProduct(['name' => 'Nama Lama', 'price' => 50000]);

        $result = $this->productService->updateProduct($product->id, [
            'name'  => 'Nama Baru',
            'price' => 75000,
        ]);

        $this->assertTrue($result);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Nama Baru', 'price' => 75000]);
    }

    /** updateProduct() mengembalikan false untuk produk yang tidak ada. */
    public function test_update_product_returns_false_for_nonexistent(): void
    {
        $result = $this->productService->updateProduct(99999, ['name' => 'X']);

        $this->assertFalse($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  DELETE PRODUCT
    // ──────────────────────────────────────────────────────────────

    /** deleteProduct() menghapus produk dari database. */
    public function test_delete_product_removes_product(): void
    {
        $product = $this->createProduct(['name' => 'Akan Dihapus']);

        $result = $this->productService->deleteProduct($product->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** deleteProduct() mengembalikan false untuk produk yang tidak ada. */
    public function test_delete_product_returns_false_for_nonexistent(): void
    {
        $result = $this->productService->deleteProduct(99999);

        $this->assertFalse($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  SEARCH PRODUCTS
    // ──────────────────────────────────────────────────────────────

    /** searchProducts() mencari berdasarkan nama. */
    public function test_search_products_finds_by_name(): void
    {
        $this->createProduct(['name' => 'Royal Canin Cat Food']);
        $this->createProduct(['name' => 'Dog Collar Leather']);

        $result = $this->productService->searchProducts('Royal');

        $this->assertCount(1, $result);
        $this->assertEquals('Royal Canin Cat Food', $result[0]['name']);
    }

    /** searchProducts() mencari berdasarkan deskripsi. */
    public function test_search_products_finds_by_description(): void
    {
        $this->createProduct(['name' => 'Produk A', 'description' => 'Pakan premium untuk anjing']);
        $this->createProduct(['name' => 'Produk B', 'description' => 'Aksesoris kucing lucu']);

        $result = $this->productService->searchProducts('premium');

        $this->assertCount(1, $result);
        $this->assertEquals('Produk A', $result[0]['name']);
    }

    /** searchProducts() mencari berdasarkan kategori. */
    public function test_search_products_finds_by_category(): void
    {
        $this->createProduct(['name' => 'Produk Makanan', 'category' => 'makanan_khusus']);
        $this->createProduct(['name' => 'Produk Lain', 'category' => 'aksesoris']);

        $result = $this->productService->searchProducts('makanan_khusus');

        $this->assertCount(1, $result);
        $this->assertEquals('Produk Makanan', $result[0]['name']);
    }

    /** searchProducts() mengembalikan array kosong jika tidak ada yang cocok. */
    public function test_search_products_returns_empty_for_no_match(): void
    {
        $this->createProduct(['name' => 'Produk Biasa']);

        $result = $this->productService->searchProducts('XYZ_TIDAK_ADA');

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /** searchProducts() dapat dikombinasikan dengan filter is_active. */
    public function test_search_products_with_active_filter(): void
    {
        $this->createProduct(['name' => 'Aktif Product', 'is_active' => true]);
        $this->createProduct(['name' => 'Aktif Product Nonactive', 'is_active' => false]);

        $result = $this->productService->searchProducts('Aktif', ['is_active' => true]);

        $this->assertCount(1, $result);
        $this->assertTrue((bool) $result[0]['is_active']);
    }

    /** searchProducts() dapat dikombinasikan dengan filter harga. */
    public function test_search_products_with_price_filter(): void
    {
        $this->createProduct(['name' => 'Murah Pet Food', 'price' => 10000]);
        $this->createProduct(['name' => 'Mahal Pet Food', 'price' => 300000]);

        $result = $this->productService->searchProducts('Pet Food', ['min_price' => 100000]);

        $this->assertCount(1, $result);
        $this->assertEquals('Mahal Pet Food', $result[0]['name']);
    }
}
