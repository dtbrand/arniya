<?php

namespace App\Controllers;

use App\Services\ProductService;
use App\Helpers\ResponseHelper;

/**
 * ProductController
 * DT Brand's & Jai Hanuman Tex
 */
class ProductController
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index(): void
    {
        $filters = [
            'category' => $_GET['category'] ?? '',
            'search' => $_GET['search'] ?? '',
            'max_price' => $_GET['max_price'] ?? ''
        ];
        $products = $this->productService->getCatalog($filters);
        ResponseHelper::success($products, 'Products retrieved successfully');
    }

    public function show(int $id): void
    {
        $product = $this->productService->getProduct($id);
        if ($product) {
            ResponseHelper::success($product, 'Product found');
        } else {
            ResponseHelper::error('Product not found', 404);
        }
    }
}
