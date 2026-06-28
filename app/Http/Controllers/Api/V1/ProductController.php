<?php

namespace App\Http\Controllers\Api\V1;

use App\Contract\ProductServiceContract;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function __construct(private ProductServiceContract $productService)
    {
    }

    /**
     * GET /api/v1/products
     * Public unified catalog (products + services) as documented in
     * docs/03-api-spec.md. Supports ?search= and ?category=product|service.
     */
    public function index(Request $request)
    {
        try {
            $catalog = $this->productService->listCatalog($request->only(['search', 'category']));

            return $this->success($catalog, 'Catalog retrieved successfully');
        } catch (\Throwable $e) {
            report($e);

            return $this->error('Failed to fetch products data.', 500);
        }
    }

    public function show(int $product)
    {
        return $this->success(new ProductResource($this->productService->getProduct($product)), 'Product retrieved successfully');
    }

    /**
     * Admin-only management endpoints below (/api/v1/admin/products).
     */
    public function adminIndex(Request $request)
    {
        $products = $this->productService->listProducts($request->only(['search', 'category', 'per_page']));

        return $this->success(ProductResource::collection($products), 'Products retrieved successfully');
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        return $this->success(new ProductResource($product), 'Product created successfully', 201);
    }

    public function update(ProductRequest $request, int $product)
    {
        $updated = $this->productService->updateProduct($product, $request->validated());

        return $this->success(new ProductResource($updated), 'Product updated successfully');
    }

    public function destroy(int $product)
    {
        $this->productService->deleteProduct($product);

        return $this->success(null, 'Product deleted successfully');
    }
}
