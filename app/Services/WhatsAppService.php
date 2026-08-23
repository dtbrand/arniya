<?php

namespace App\Services;

use DTBrand\OrderManager;

/**
 * WhatsAppService
 * DT Brand's & Jai Hanuman Tex
 */
class WhatsAppService
{
    public function generateConfirmationNotice(string $orderNumber, float $grandTotal, string $customerName): string
    {
        return OrderManager::generateWhatsAppNotice($orderNumber, $grandTotal, $customerName);
    }
}
