<?php

namespace App\Controllers;

use App\Helpers\ResponseHelper;
use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;

/**
 * CartController
 * DT Brand's & Jai Hanuman Tex
 */
class CartController
{
    public function getCart(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $items = array_values($_SESSION['cart_items'] ?? []);
        $subtotal = 0.0;
        foreach ($items as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $pricing = PricingCalculator::calculateOrderTotal($subtotal, 0.0, ($subtotal > 0 && $subtotal < 1999) ? 150.0 : 0.0, 5.0);
        ResponseHelper::success([
            'items' => $items,
            'pricing' => $pricing
        ]);
    }
}
