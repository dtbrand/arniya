<?php

namespace App\Repositories;

use App\Models\Product;

/**
 * ProductRepository
 * DT Brand's & Jai Hanuman Tex
 */
class ProductRepository
{
    public function getAll(): array
    {
        return Product::all();
    }

    public function findById(int $id): ?array
    {
        return Product::find($id);
    }

    public function filter(array $criteria): array
    {
        return Product::where($criteria);
    }
}
