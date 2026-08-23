<?php

namespace App\Services;

use App\Repositories\ProductRepository;

/**
 * ProductService
 * DT Brand's & Jai Hanuman Tex
 */
class ProductService
{
    private ProductRepository $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepository();
    }

    public function getCatalog(array $filters = []): array
    {
        return $this->productRepo->filter($filters);
    }

    public function getProduct(int $id): ?array
    {
        return $this->productRepo->findById($id);
    }
}
