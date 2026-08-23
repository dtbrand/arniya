<?php

namespace App\Controllers;

use App\Helpers\ResponseHelper;
use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;

/**
 * WholesaleController
 * DT Brand's & Jai Hanuman Tex
 */
class WholesaleController
{
    public function calculateLot(int $productId, string $lotType): void
    {
        $product = ProductCatalog::getById($productId) ?? ProductCatalog::getAll()[0];
        $qty = match($lotType) {
            'single' => 1,
            'half_set' => 4,
            'full_set' => 8,
            'master_bale' => 24,
            default => 4
        };
        $discount = match($lotType) {
            'single' => 0.0,
            'half_set' => 30.0,
            'full_set' => 40.0,
            'master_bale' => 48.0,
            default => 30.0
        };
        $unitPrice = PricingCalculator::calculateWholesalePrice($product['mrp'], $discount);
        $total = PricingCalculator::calculateOrderTotal($unitPrice * $qty, 0.0, 0.0, 5.0);

        ResponseHelper::success([
            'lot_type' => $lotType,
            'pieces' => $qty,
            'unit_price' => $unitPrice,
            'pricing' => $total
        ]);
    }
}
