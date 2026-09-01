<?php
/**
 * config/payment.php — Dynamic Multi-Gateway Payment Configuration
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/PaymentManager.php';

use DTBrand\PaymentManager;

$gateways = PaymentManager::getAllGateways(false);

return [
    'default'  => 'direct_upi',
    'gateways' => $gateways,
    'public'   => PaymentManager::getPublicConfig()
];
