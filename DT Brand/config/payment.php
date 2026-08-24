<?php
/**
 * config/payment.php — Payment Gateways Configuration
 * DT Brand's & Jai Hanuman Tex
 */

return [
    'default' => 'razorpay',
    'gateways' => [
        'razorpay' => [
            'key_id' => getenv('RAZORPAY_KEY_ID') ?: 'rzp_live_default',
            'key_secret' => getenv('RAZORPAY_KEY_SECRET') ?: '',
            'webhook_secret' => getenv('RAZORPAY_WEBHOOK_SECRET') ?: ''
        ],
        'cod' => [
            'enabled' => true,
            'fee' => 0.0,
            'max_order_amount' => 15000.00
        ],
        'bank_wire' => [
            'enabled' => true,
            'bank_name' => 'HDFC Bank',
            'account_name' => 'Jai Hanuman Tex',
            'account_number' => '50200084920194',
            'ifsc_code' => 'HDFC0000124',
            'branch' => 'Ring Road, Surat'
        ]
    ]
];
