<?php

namespace App\DTOs;

/**
 * ProductDTO — Data Transfer Object for Products
 * DT Brand's & Jai Hanuman Tex
 */
class ProductDTO
{
    public function __construct(
        public string $sku,
        public string $title,
        public string $category,
        public string $fabric,
        public float $mrp,
        public float $retailPrice,
        public float $wholesalePrice,
        public float $resellerPrice,
        public int $stockQty = 0,
        public string $status = 'in_stock'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sku: (string)($data['sku'] ?? ''),
            title: (string)($data['title'] ?? ''),
            category: (string)($data['category'] ?? ''),
            fabric: (string)($data['fabric'] ?? ''),
            mrp: (float)($data['mrp'] ?? 0.0),
            retailPrice: (float)($data['retail_price'] ?? 0.0),
            wholesalePrice: (float)($data['wholesale_price'] ?? 0.0),
            resellerPrice: (float)($data['reseller_price'] ?? 0.0),
            stockQty: (int)($data['stock_qty'] ?? 0),
            status: (string)($data['status'] ?? 'in_stock')
        );
    }
}
