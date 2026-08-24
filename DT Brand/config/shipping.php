<?php
/**
 * config/shipping.php — Courier & Freight Logistics Configuration
 * DT Brand's & Jai Hanuman Tex
 */

return [
    'default_courier' => 'delhivery',
    'free_shipping_threshold' => 1999.00,
    'standard_rate' => 150.00,
    'couriers' => [
        'delhivery' => [
            'name' => 'Delhivery Express',
            'api_token' => getenv('DELHIVERY_API_TOKEN') ?: '',
            'service_type' => 'Express Surface / Air'
        ],
        'bluedart' => [
            'name' => 'Blue Dart Aviation',
            'client_id' => getenv('BLUEDART_CLIENT_ID') ?: '',
            'service_type' => 'Air Express'
        ],
        'tci_freight' => [
            'name' => 'TCI Freight Cargo',
            'account_id' => getenv('TCI_ACCOUNT_ID') ?: '',
            'service_type' => 'B2B Heavy Surface'
        ]
    ]
];
