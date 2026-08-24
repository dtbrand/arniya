<?php
/**
 * config/whatsapp.php — Meta WhatsApp Cloud API Configuration
 * DT Brand's & Jai Hanuman Tex
 */

return [
    'phone_number_id' => getenv('WHATSAPP_PHONE_ID') ?: '1098492019482',
    'business_account_id' => getenv('WHATSAPP_WABA_ID') ?: '2049281048192',
    'access_token' => getenv('WHATSAPP_ACCESS_TOKEN') ?: '',
    'verify_token' => getenv('WHATSAPP_VERIFY_TOKEN') ?: 'dtbrand_meta_secret_2026',
    'api_version' => 'v19.0',
    'templates' => [
        'order_confirmation' => 'dt_order_confirm_v1',
        'dispatch_tracking' => 'dt_order_dispatch_v2',
        'catalogue_broadcast' => 'dt_festive_catalogue_alert'
    ]
];
