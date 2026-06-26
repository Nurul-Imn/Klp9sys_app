<?php

namespace App\Services;

use App\Contract\ProductServiceContract;
use App\Models\Product;

class ProductService implements ProductServiceContract
{
    /**
     * Menampilkan semua produk
     */
    public function listProducts(array $filters = []): array
    {
        $query = Product::query();

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Menampilkan detail produk
     */
    public function getProduct(int $id): array
    {
        $product = Product::find($id);

        return $product ? $product->toArray() : [];
    }

    /**
     * Menambah produk baru
     */
    public function createProduct(array $data): array
    {
        $product = Product::create([
            'name'        => $data['name'],
            'category'    => $data['category'],
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'description' => $data['description'] ?? null,
            'is_active'   => $data['is_active'] ?? true,
        ]);

        return $product->toArray();
    }

    /**
     * Mengubah data produk
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
     * Menghapus produk
     */
    public function deleteProduct(int $id): bool
    {
        $product = Product::find($id);

        if (!$product) {
            return false;
        }

        return (bool) $product->delete();
    }

    /**
     * Mencari produk
     */
    public function searchProducts(string $query, array $filters = []): array
    {
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%");

        if (isset($filters['category'])) {
            $products->where('category', $filters['category']);
        }

        if (isset($filters['is_active'])) {
            $products->where('is_active', $filters['is_active']);
        }

        return $products
            ->orderBy('name')
            ->get()
            ->toArray();
    }
}