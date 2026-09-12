<?php
/**
 * api/index.php — Master API Directory & Gateway
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'platform' => "DT Brand's & Jai Hanuman Tex — Luxury Ethnic API",
    'version' => '1.0.0',
    'status' => 'operational',
    'endpoints' => [
        'admin_security' => '/api/admin_security.php',
        'attributes' => '/api/attributes.php',
        'audit' => '/api/audit.php',
        'brands' => '/api/brands.php',
        'health' => '/api/health.php',
        'products' => '/api/products/index.php',
        'products_direct' => '/api/products.php',
        'products_import' => '/api/products/import.php',
        'products_export' => '/api/products/export.php',
        'categories' => '/api/categories/index.php',
        'categories_direct' => '/api/categories.php',
        'cart' => '/api/cart/index.php',
        'wishlist' => '/api/wishlist/index.php',
        'orders' => '/api/orders/index.php',
        'orders_direct' => '/api/orders.php',
        'customers' => '/api/customers/index.php',
        'customers_direct' => '/api/customers.php',
        'customer_addresses' => '/api/customer_addresses.php',
        'customer_notes' => '/api/customer_notes.php',
        'content' => '/api/content.php',
        'coupons' => '/api/coupons.php',
        'integrations' => '/api/integrations.php',
        'reseller' => '/api/reseller/index.php',
        'retailer' => '/api/retailer/index.php',
        'wholesale' => '/api/wholesale/index.php',
        'payments' => '/api/payments/index.php',
        'payments_direct' => '/api/payments.php',
        'payment_create_order' => '/api/payment/create_order.php',
        'payment_verify' => '/api/payment/verify.php',
        'payment_config' => '/api/payment/config.php',
        'payment_admin_save' => '/api/payment/admin_save.php',
        'upi_status' => '/api/payments/upi_status.php',
        'upi_verify' => '/api/payments/upi_verify.php',
        'shipping' => '/api/shipping/index.php',
        'shipping_direct' => '/api/shipping.php',
        'media' => '/api/media/index.php',
        'media_delete' => '/api/media/delete.php',
        'notifications' => '/api/notifications/index.php',
        'notifications_direct' => '/api/notifications.php',
        'reports' => '/api/reports.php',
        'reviews' => '/api/reviews.php',
        'settings' => '/api/settings.php',
        'system' => '/api/system.php',
        'system_backup' => '/api/system/backup.php',
        'upload' => '/api/upload.php',
        'users' => '/api/users.php',
        'variants' => '/api/variants.php',
        'whatsapp' => '/api/whatsapp/index.php',
        'whatsapp_direct' => '/api/whatsapp.php',
        'whatsapp_audience' => '/api/whatsapp/audience.php',
        'webhook_razorpay' => '/api/webhooks/razorpay.php',
        'webhook_cashfree' => '/api/webhooks/cashfree.php',
        'webhook_delhivery' => '/api/webhooks/delhivery.php',
        'webhook_bluedart' => '/api/webhooks/bluedart.php',
        'webhook_tci' => '/api/webhooks/tci.php',
        'webhook_whatsapp' => '/api/webhooks/whatsapp.php'
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
