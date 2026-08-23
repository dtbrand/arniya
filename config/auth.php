<?php
/**
 * config/auth.php — Authentication & Session Guards
 * DT Brand's & Jai Hanuman Tex
 */

return [
    'session_lifetime' => (int)(getenv('SESSION_LIFETIME') ?: 86400),
    'admin_prefix' => 'adm_',
    'roles' => [
        'super_admin' => ['all'],
        'manager' => ['products', 'orders', 'inventory', 'shipping'],
        'dispatch' => ['orders', 'shipping'],
        'reseller' => ['catalog', 'orders', 'margins'],
        'wholesaler' => ['catalog', 'bulk_orders', 'ledgers']
    ]
];
