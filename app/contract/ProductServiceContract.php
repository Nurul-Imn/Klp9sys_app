<?php

namespace App\Contract;

interface ProductServiceContract
{
    public function listProducts(array $filters = []): array;

    public function getProduct(int $id): array;

    public function createProduct(array $data): array;

    public function updateProduct(int $id, array $data): bool;

    public function deleteProduct(int $id): bool;

    public function searchProducts(string $query, array $filters = []): array;
}
