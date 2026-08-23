<?php

namespace App\Repositories;

use App\Models\Customer;

/**
 * CustomerRepository
 * DT Brand's & Jai Hanuman Tex
 */
class CustomerRepository
{
    public function getAll(): array
    {
        return Customer::all();
    }

    public function findById(int $id): ?array
    {
        return Customer::find($id);
    }

    public function getByType(string $type): array
    {
        return Customer::ofType($type);
    }
}
