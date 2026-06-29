<?php

namespace App\Services;

use App\Contract\ProductServiceContract;
use App\Models\Product;

class ProductService implements ProductServiceContract
{
    /**
     * List products with optional filters.
     */
    public function listProducts(array $filters = []): array
    {
        $query = Product::query();

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query->latest()->get()->toArray();
    }

    /**
     * Get a single product by ID.
     */
    public function getProduct(int $id): array
    {
        return Product::findOrFail($id)->toArray();
    }

    /**
     * Create a new product.
     */
    public function createProduct(array $data): array
    {
        $product = Product::create($data);
        return $product->toArray();
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(int $id, array $data): bool
    {
        $product = Product::find($id);

        if (!$product) {
            return false;
        }

        return $product->update($data);
    }

    /**
     * Delete a product.
     */
    public function deleteProduct(int $id): bool
    {
        $product = Product::find($id);

        if (!$product) {
            return false;
        }

        return $product->delete();
    }

    /**
     * Search products by keyword with optional filters.
     */
    public function searchProducts(string $query, array $filters = []): array
    {
        $q = Product::where(function ($builder) use ($query) {
            $builder->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%");
        });

        if (isset($filters['is_active'])) {
            $q->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['category'])) {
            $q->where('category', $filters['category']);
        }

        if (!empty($filters['min_price'])) {
            $q->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $q->where('price', '<=', $filters['max_price']);
        }

        return $q->latest()->get()->toArray();
    }
}
