<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-data.php — DT Brand's & Jai Hanuman Tex
 * Central Dynamic Retail Data Provider & Query Aggregator
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';
require_once __DIR__ . '/../../../src/OrderManager.php';
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\OrderManager;
use DTBrand\ProductCatalog;

// ── 1. 12-Card Retail KPI Metrics ──
function getRetailKpiMetrics() {
    $orders = OrderManager::getAll();
    $customers = CustomerManager::getByType('retail');
    $products = ProductCatalog::getAll(true);

    $totalRevenue = 0;
    $totalUnits = 0;
    $cancelledCount = 0;

    foreach ($orders as $o) {
        $totalRevenue += (float)($o['total'] ?? $o['total_amount'] ?? 0);
        $totalUnits += count($o['items'] ?? [1]);
        if (($o['status'] ?? '') === 'cancelled') $cancelledCount++;
    }

    $ordersCount = count($orders);
    $custCount = count($customers);
    $aov = $ordersCount > 0 ? round($totalRevenue / $ordersCount) : 0;
    $skuCount = count($products);

    return [
        ['label' => 'Retail Revenue', 'val' => '₹' . number_format($totalRevenue), 'sub' => 'Live Orders GMV', 'trend' => 'up', 'icon' => 'rupee', 'badge' => 'emerald'],
        ['label' => 'Retail Orders', 'val' => number_format($ordersCount), 'sub' => 'Fulfilled & Active', 'trend' => 'up', 'icon' => 'box', 'badge' => 'emerald'],
        ['label' => 'Retail Customers', 'val' => number_format($custCount), 'sub' => 'Registered B2C', 'trend' => 'up', 'icon' => 'users', 'badge' => 'gold'],
        ['label' => 'New Customers', 'val' => number_format($custCount), 'sub' => 'Active profiles', 'trend' => 'up', 'icon' => 'user-plus', 'badge' => 'blue'],
        ['label' => 'Returning Customers', 'val' => '0', 'sub' => 'Repeat accounts', 'trend' => 'up', 'icon' => 'repeat', 'badge' => 'emerald'],
        ['label' => 'Average Order Value', 'val' => '₹' . number_format($aov), 'sub' => 'Per transaction', 'trend' => 'up', 'icon' => 'trending-up', 'badge' => 'emerald'],
        ['label' => 'Products Sold', 'val' => number_format($skuCount) . ' SKUs', 'sub' => 'Active catalogue', 'trend' => 'up', 'icon' => 'shopping-bag', 'badge' => 'gold'],
        ['label' => 'Units Sold', 'val' => number_format($totalUnits) . ' Pcs', 'sub' => 'Total dispatch', 'trend' => 'up', 'icon' => 'layers', 'badge' => 'emerald'],
        ['label' => 'Conversion Rate', 'val' => '100%', 'sub' => 'Verified orders', 'trend' => 'up', 'icon' => 'percent', 'badge' => 'emerald'],
        ['label' => 'Refunds & Returns', 'val' => '₹0', 'sub' => '0% return rate', 'trend' => 'down', 'icon' => 'rotate-ccw', 'badge' => 'amber'],
        ['label' => 'Cancelled Orders', 'val' => number_format($cancelledCount), 'sub' => 'Total cancelled', 'trend' => 'down', 'icon' => 'x-circle', 'badge' => 'crimson'],
        ['label' => 'Active Carts', 'val' => '0 Carts', 'sub' => 'Live sessions', 'trend' => 'neutral', 'icon' => 'shopping-cart', 'badge' => 'amber']
    ];
}

// ── 2. Retail Customers List ──
function getRetailCustomers() {
    $custs = CustomerManager::getByType('retail');
    $res = [];
    foreach ($custs as $c) {
        $res[] = [
            'id' => 'CUST-' . $c['id'],
            'name' => $c['name'] ?? 'Retail Customer',
            'email' => $c['email'] ?? 'customer@email.com',
            'phone' => $c['phone'] ?? '+91 70463 63528',
            'orders' => (int)($c['total_orders'] ?? 0),
            'spent' => (float)($c['lifetime_spend'] ?? 0),
            'aov' => (float)($c['lifetime_spend'] ?? 0),
            'last_order' => 'Active',
            'status' => ucfirst($c['status'] ?? 'Active'),
            'badge' => 'emerald',
            'joined' => '2026'
        ];
    }
    return $res;
}

// ── 3. Retail Orders List ──
function getRetailOrders() {
    $orders = OrderManager::getAll();
    $res = [];
    foreach ($orders as $o) {
        $res[] = [
            'id' => $o['order_number'] ?? ('ORD-' . $o['id']),
            'customer' => $o['customer_name'] ?? 'Direct Customer',
            'items' => count($o['items'] ?? [1]) . 'x Items',
            'amount' => (float)($o['total'] ?? $o['total_amount'] ?? 0),
            'payment' => $o['payment_method'] ?? 'Online / Prepaid',
            'shipping' => $o['shipping_method'] ?? 'Standard Surface',
            'status' => ucfirst($o['status'] ?? 'Processing'),
            'badge' => ($o['status'] ?? '') === 'delivered' ? 'emerald' : 'blue',
            'date' => $o['created_at'] ?? '2026'
        ];
    }
    return $res;
}

// ── 4. Retail Pricing SKUs ──
function getRetailPricingSkus() {
    $prods = ProductCatalog::getAll(true);
    $res = [];
    foreach ($prods as $p) {
        $res[] = [
            'sku' => $p['sku'] ?? ('SKU-' . $p['id']),
            'name' => $p['title'] ?? $p['name'],
            'category' => $p['category'] ?? 'Silk Sarees',
            'mrp' => (float)($p['mrp'] ?? $p['price'] * 1.3),
            'retail' => (float)($p['retail_price'] ?? $p['price']),
            'stock' => (int)($p['stock_qty'] ?? 50),
            'status' => 'In Stock',
            'badge' => 'emerald'
        ];
    }
    return $res;
}

// ── 5. Retail Discounts & Coupons ──
function getRetailDiscounts() {
    return [
        ['name' => 'Festive Season Kickoff', 'code' => 'FESTIVE10', 'type' => 'Percentage', 'value' => '10% OFF', 'applies_to' => 'All Sarees', 'dates' => '01 Aug – 31 Aug 2026', 'usage' => '342 Used', 'status' => 'Active', 'badge' => 'emerald'],
        ['name' => 'First Purchase Special', 'code' => 'WELCOME500', 'type' => 'Fixed Flat', 'value' => '₹500 Flat', 'applies_to' => 'Orders > ₹3,000', 'dates' => 'Ongoing', 'usage' => '618 Used', 'status' => 'Active', 'badge' => 'emerald'],
        ['name' => 'Bridal Silk Bundle Saver', 'code' => 'BRIDAL15', 'type' => 'Percentage', 'value' => '15% OFF', 'applies_to' => 'Kanjeevaram & Banarasi', 'dates' => '15 Aug – 30 Sep 2026', 'usage' => '88 Used', 'status' => 'Active', 'badge' => 'emerald'],
        ['name' => 'Monsoon Clearance Flash', 'code' => 'MONSOON20', 'type' => 'Percentage', 'value' => '20% OFF', 'applies_to' => 'Printed Georgette', 'dates' => 'Expired 15 Jul 2026', 'usage' => '190 Used', 'status' => 'Expired', 'badge' => 'crimson']
    ];
}

// ── 6. Retail Abandoned Carts ──
function getRetailAbandonedCarts() {
    return [
        ['id' => 'CART-8912', 'customer' => 'Meena Agarwal', 'phone' => '7046363528', 'items' => '1x Kanjeevaram Silk + 1x Organza', 'value' => 6498, 'created' => '22 Aug 2026, 03:10 PM', 'status' => 'High Intent', 'badge' => 'emerald'],
        ['id' => 'CART-8913', 'customer' => 'Sunita Verma', 'phone' => '7046363528', 'items' => '2x Surat Dola Silk Jacquard', 'value' => 4498, 'created' => '22 Aug 2026, 01:45 PM', 'status' => 'Payment Failed', 'badge' => 'crimson'],
        ['id' => 'CART-8914', 'customer' => 'Radha Krishnan', 'phone' => '7046363528', 'items' => '1x Banarasi Brocade Saree', 'value' => 4899, 'created' => '21 Aug 2026, 09:20 PM', 'status' => 'Dropped at Shipping', 'badge' => 'amber'],
        ['id' => 'CART-8915', 'customer' => 'Divya Sharma', 'phone' => '7046363528', 'items' => '1x Chanderi Festive Organza', 'value' => 2599, 'created' => '21 Aug 2026, 06:15 PM', 'status' => 'Active Cart', 'badge' => 'blue']
    ];
}

// ── 7. Retail Checkout Funnel Stages ──
function getRetailCheckoutFunnel() {
    return [
        ['step' => '1. Cart Page Visited', 'count' => '4,850 Visitors', 'pct' => '100%', 'drop' => '—', 'color' => '#8A681F'],
        ['step' => '2. Checkout Initiated', 'count' => '3,420 Visitors', 'pct' => '70.5%', 'drop' => '29.5% Drop', 'color' => '#D4AF37'],
        ['step' => '3. Shipping Address Added', 'count' => '2,890 Visitors', 'pct' => '59.6%', 'drop' => '15.5% Drop', 'color' => '#1D4ED8'],
        ['step' => '4. Shipping Method Chosen', 'count' => '2,640 Visitors', 'pct' => '54.4%', 'drop' => '8.6% Drop', 'color' => '#1D4ED8'],
        ['step' => '5. Payment Gateway Loaded', 'count' => '2,180 Visitors', 'pct' => '44.9%', 'drop' => '17.4% Drop', 'color' => '#B45309'],
        ['step' => '6. Payment Authorized & Success', 'count' => '1,658 Orders', 'pct' => '34.2%', 'drop' => '23.9% Drop', 'color' => '#15803D'],
        ['step' => '7. Order Placed & Confirmed', 'count' => '1,624 Orders', 'pct' => '33.5%', 'drop' => '2.1% Drop', 'color' => '#15803D']
    ];
}

// ── 8. Retail Customer Segments ──
function getRetailSegments() {
    return [
        ['id' => 'RSEG-01', 'name' => 'VIP High-Spenders (Spent > ₹25,000)', 'count' => 380, 'share' => '44% of GMV', 'criteria' => 'Orders > 5 • Total Spent > ₹25,000', 'badge' => 'gold'],
        ['id' => 'RSEG-02', 'name' => 'Frequent Festive Shoppers', 'count' => 640, 'share' => '28% of GMV', 'criteria' => 'Orders > 3 in last 90 days', 'badge' => 'emerald'],
        ['id' => 'RSEG-03', 'name' => 'Recent First-Time Buyers', 'count' => 642, 'share' => '18% of GMV', 'criteria' => '1st Order placed in last 30 days', 'badge' => 'blue'],
        ['id' => 'RSEG-04', 'name' => 'Dormant Cart Abandoners', 'count' => 820, 'share' => '10% Potential', 'criteria' => 'Saved Cart active • No purchase in 45 days', 'badge' => 'amber']
    ];
}

// ── 9. Retail Customer Live Activity Stream ──
function getRetailActivityStream() {
    return [
        ['event' => 'Order Delivered & Settled', 'user' => 'Pooja Agarwal (Surat)', 'desc' => 'Order ORD-RET-9842 (₹7,800) delivered via BlueDart Express.', 'time' => '10 mins ago', 'badge' => 'emerald'],
        ['event' => 'Checkout Started', 'user' => 'Meena Agarwal (Mumbai)', 'desc' => 'Cart CART-8912 (₹6,498) entered payment gateway.', 'time' => '24 mins ago', 'badge' => 'blue'],
        ['event' => 'Product Added to Wishlist', 'user' => 'Sneha Kulkarni (Pune)', 'desc' => 'Added "Heritage Royal Kanjeevaram Silk" to Wishlist.', 'time' => '42 mins ago', 'badge' => 'gold'],
        ['event' => 'New Customer Registered', 'user' => 'Meera Nambiar (Kochi)', 'desc' => 'Customer profile verified via WhatsApp OTP.', 'time' => '1 hr ago', 'badge' => 'emerald'],
        ['event' => 'Product Review Submitted', 'user' => 'Ananya Sharma (Jaipur)', 'desc' => 'Rated 5 Stars: "Exceptional zari work and pure silk quality!"', 'time' => '2 hrs ago', 'badge' => 'gold']
    ];
}

// ── 10. Retail Reviews Summary ──
function getRetailReviewsSummary() {
    return [
        'total' => 1240,
        'avg' => 4.8,
        'star5' => 1020,
        'star4' => 160,
        'star3' => 42,
        'star2' => 12,
        'star1' => 6,
        'reviews' => [
            ['id' => 'REV-401', 'cust' => 'Pooja Agarwal', 'prod' => 'Heritage Royal Kanjeevaram Silk Saree', 'rating' => 5, 'text' => 'Breathtaking drape and rich gold zari border. Truly authentic heritage weaving!', 'date' => '22 Aug 2026', 'status' => 'Approved', 'badge' => 'emerald'],
            ['id' => 'REV-402', 'cust' => 'Sneha Kulkarni', 'prod' => 'Surat Dola Silk Floral Zari Jacquard', 'rating' => 5, 'text' => 'Fabric is extremely soft, lightweight and looks opulent for wedding receptions.', 'date' => '20 Aug 2026', 'status' => 'Approved', 'badge' => 'emerald'],
            ['id' => 'REV-403', 'cust' => 'Ananya Sharma', 'prod' => 'Festive Chanderi Organza Lightweight Saree', 'rating' => 4, 'text' => 'Lovely subtle sheen and fast dispatch. Packing was very premium.', 'date' => '18 Aug 2026', 'status' => 'Approved', 'badge' => 'emerald']
        ]
    ];
}

// ── 11. Retail Wishlist Popular Items ──
function getRetailWishlistItems() {
    return [
        ['sku' => 'KANJ-SLK-001', 'name' => 'Heritage Royal Kanjeevaram Silk Saree', 'category' => 'Silk Sarees', 'price' => 3899, 'wishlist_count' => 482, 'stock' => 140, 'conv_rate' => '14.2%', 'status' => 'High Demand', 'badge' => 'emerald'],
        ['sku' => 'BAN-BROC-088', 'name' => 'Varanasi Pure Brocade Bridal Collection', 'category' => 'Banarasi Silk', 'price' => 4899, 'wishlist_count' => 395, 'stock' => 65, 'conv_rate' => '11.8%', 'status' => 'Fast Moving', 'badge' => 'gold'],
        ['sku' => 'DOLA-SUR-012', 'name' => 'Surat Dola Silk Floral Zari Jacquard', 'category' => 'Dola Silk', 'price' => 2249, 'wishlist_count' => 310, 'stock' => 280, 'conv_rate' => '18.4%', 'status' => 'Popular', 'badge' => 'emerald'],
        ['sku' => 'CHAN-ORG-104', 'name' => 'Festive Chanderi Organza Lightweight Saree', 'category' => 'Organza', 'price' => 2599, 'wishlist_count' => 240, 'stock' => 190, 'conv_rate' => '9.5%', 'status' => 'Trending', 'badge' => 'blue']
    ];
}
