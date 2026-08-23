<?php

namespace App\Models;

use DTBrand\CustomerManager;

/**
 * Customer Model
 * DT Brand's & Jai Hanuman Tex
 */
class Customer
{
    public static function all(): array
    {
        return CustomerManager::getAll();
    }

    public static function find(int $id): ?array
    {
        return CustomerManager::getById($id);
    }

    public static function ofType(string $type): array
    {
        return CustomerManager::getByType($type);
    }
}
