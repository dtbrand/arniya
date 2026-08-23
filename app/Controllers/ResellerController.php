<?php

namespace App\Controllers;

use App\Helpers\ResponseHelper;
use DTBrand\ProductCatalog;

/**
 * ResellerController
 * DT Brand's & Jai Hanuman Tex
 */
class ResellerController
{
    public function calculateMargin(int $productId, float $marginPercent): void
    {
        $product = ProductCatalog::getById($productId) ?? ProductCatalog::getAll()[0];
        $margin = round($product['reseller_price'] * ($marginPercent / 100), 2);
        ResponseHelper::success([
            'reseller_base_price' => $product['reseller_price'],
            'margin_percent' => $marginPercent,
            'reseller_profit' => $margin,
            'final_price' => $product['reseller_price'] + $margin,
            'smart_share_url' => "https://jaihanumantex.in/Frontend/Single-Product/singleproduct.php?id={$product['id']}&ref=reseller_vip"
        ]);
    }
}
