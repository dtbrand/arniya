<?php

namespace App\Models;

use DTBrand\ProductCatalog;

/**
 * Product Model
 * DT Brand's & Jai Hanuman Tex
 */
class Product
{
    public static function all(): array
    {
        return ProductCatalog::getAll();
    }

    public static function find(int $id): ?array
    {
        return ProductCatalog::getById($id);
    }

    public static function where(array $criteria): array
    {
        return ProductCatalog::filter($criteria);
    }
}
