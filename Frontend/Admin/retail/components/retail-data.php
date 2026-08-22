<?php
/**
 * retail-data.php — DT Brand's & Jai Hanuman Tex
 * Central Dynamic Retail Data Provider & Query Aggregator
 */

// ── 1. 12-Card Retail KPI Metrics ──
function getRetailKpiMetrics() {
    return [
        ['label' => 'Retail Revenue', 'val' => '₹58.4 Lakhs', 'sub' => '+28.4% YoY', 'trend' => 'up', 'icon' => 'rupee', 'badge' => 'emerald'],
        ['label' => 'Retail Orders', 'val' => '1,624', 'sub' => '+18.2% this mo', 'trend' => 'up', 'icon' => 'box', 'badge' => 'emerald'],
        ['label' => 'Retail Customers', 'val' => '4,820', 'sub' => '+140 new', 'trend' => 'up', 'icon' => 'users', 'badge' => 'gold'],
        ['label' => 'New Customers', 'val' => '642', 'sub' => '39.5% of total', 'trend' => 'up', 'icon' => 'user-plus', 'badge' => 'blue'],
        ['label' => 'Returning Customers', 'val' => '982', 'sub' => '60.5% repeat', 'trend' => 'up', 'icon' => 'repeat', 'badge' => 'emerald'],
        ['label' => 'Average Order Value', 'val' => '₹3,596', 'sub' => '+8.6% vs Retail', 'trend' => 'up', 'icon' => 'trending-up', 'badge' => 'emerald'],
        ['label' => 'Products Sold', 'val' => '482 SKUs', 'sub' => 'Active catalogue', 'trend' => 'up', 'icon' => 'shopping-bag', 'badge' => 'gold'],
        ['label' => 'Units Sold', 'val' => '3,890 Pcs', 'sub' => '+22.5% volume', 'trend' => 'up', 'icon' => 'layers', 'badge' => 'emerald'],
        ['label' => 'Conversion Rate', 'val' => '3.42%', 'sub' => 'Visitor to order', 'trend' => 'up', 'icon' => 'percent', 'badge' => 'emerald'],
        ['label' => 'Refunds & Returns', 'val' => '₹18,400', 'sub' => '0.31% return rate', 'trend' => 'down', 'icon' => 'rotate-ccw', 'badge' => 'amber'],
        ['label' => 'Cancelled Orders', 'val' => '14', 'sub' => '0.86% cancellation', 'trend' => 'down', 'icon' => 'x-circle', 'badge' => 'crimson'],
        ['label' => 'Abandoned Carts', 'val' => '128 Carts', 'sub' => '₹4.2L potential', 'trend' => 'neutral', 'icon' => 'shopping-cart', 'badge' => 'amber']
    ];
}

// ── 2. Retail Customers List ──
function getRetailCustomers() {
    return [
        ['id' => 'CUST-1048', 'name' => 'Pooja Agarwal', 'email' => 'pooja.agarwal@gmail.com', 'phone' => '+91 98201 45821', 'orders' => 14, 'spent' => 48200, 'aov' => 3442, 'last_order' => '22 Aug 2026', 'status' => 'VIP Gold', 'badge' => 'gold', 'joined' => '12 Jan 2025'],
        ['id' => 'CUST-1049', 'name' => 'Sneha Kulkarni', 'email' => 'sneha.k@outlook.com', 'phone' => '+91 97112 88410', 'orders' => 8, 'spent' => 29400, 'aov' => 3675, 'last_order' => '20 Aug 2026', 'status' => 'Active', 'badge' => 'emerald', 'joined' => '05 Mar 2025'],
        ['id' => 'CUST-1050', 'name' => 'Ananya Sharma', 'email' => 'ananya.s@yahoo.com', 'phone' => '+91 98450 33190', 'orders' => 6, 'spent' => 21800, 'aov' => 3633, 'last_order' => '18 Aug 2026', 'status' => 'Active', 'badge' => 'emerald', 'joined' => '18 May 2025'],
        ['id' => 'CUST-1051', 'name' => 'Kavita Patel', 'email' => 'kavita.patel@gmail.com', 'phone' => '+91 99042 11560', 'orders' => 4, 'spent' => 15200, 'aov' => 3800, 'last_order' => '15 Aug 2026', 'status' => 'Active', 'badge' => 'emerald', 'joined' => '02 Jul 2025'],
        ['id' => 'CUST-1052', 'name' => 'Meera Nambiar', 'email' => 'meera.nambiar@gmail.com', 'phone' => '+91 94471 90230', 'orders' => 1, 'spent' => 3950, 'aov' => 3950, 'last_order' => '10 Aug 2026', 'status' => 'New Customer', 'badge' => 'blue', 'joined' => '10 Aug 2026'],
        ['id' => 'CUST-1053', 'name' => 'Ritu Saxena', 'email' => 'ritu.saxena@rediffmail.com', 'phone' => '+91 98100 66720', 'orders' => 0, 'spent' => 0, 'aov' => 0, 'last_order' => '—', 'status' => 'Registered', 'badge' => 'gold', 'joined' => '08 Aug 2026']
    ];
}

// ── 3. Retail Orders List ──
function getRetailOrders() {
    return [
        ['id' => 'ORD-RET-9842', 'customer' => 'Pooja Agarwal', 'items' => '2x Pure Kanjeevaram Silk Saree', 'amount' => 7800, 'payment' => 'UPI / GPay', 'shipping' => 'BlueDart Express', 'status' => 'Delivered', 'badge' => 'emerald', 'date' => '22 Aug 2026, 04:15 PM'],
        ['id' => 'ORD-RET-9841', 'customer' => 'Sneha Kulkarni', 'items' => '1x Surat Dola Silk Jacquard Saree', 'amount' => 2450, 'payment' => 'Credit Card', 'shipping' => 'Delhivery Surface', 'status' => 'In Transit', 'badge' => 'blue', 'date' => '22 Aug 2026, 01:20 PM'],
        ['id' => 'ORD-RET-9840', 'customer' => 'Ananya Sharma', 'items' => '3x Chanderi Festive Organza Sarees', 'amount' => 8900, 'payment' => 'Net Banking', 'shipping' => 'BlueDart Express', 'status' => 'Processing', 'badge' => 'amber', 'date' => '21 Aug 2026, 07:45 PM'],
        ['id' => 'ORD-RET-9839', 'customer' => 'Kavita Patel', 'items' => '1x Banarasi Brocade Bridal Saree', 'amount' => 4600, 'payment' => 'Cash on Delivery', 'shipping' => 'DTDC Air', 'status' => 'Processing', 'badge' => 'amber', 'date' => '21 Aug 2026, 03:10 PM'],
        ['id' => 'ORD-RET-9838', 'customer' => 'Meera Nambiar', 'items' => '1x Pure Silk Designer Kurti Set', 'amount' => 3950, 'payment' => 'UPI / PhonePe', 'shipping' => 'BlueDart Express', 'status' => 'Delivered', 'badge' => 'emerald', 'date' => '20 Aug 2026, 11:30 AM']
    ];
}

// ── 4. Retail Pricing SKUs ──
function getRetailPricingSkus() {
    return [
        ['sku' => 'KANJ-SLK-001', 'name' => 'Heritage Royal Kanjeevaram Silk Saree', 'category' => 'Silk Sarees', 'mrp' => 5999, 'retail' => 3899, 'stock' => 140, 'status' => 'In Stock', 'badge' => 'emerald'],
        ['sku' => 'DOLA-SUR-012', 'name' => 'Surat Dola Silk Floral Zari Jacquard', 'category' => 'Dola Silk', 'mrp' => 3499, 'retail' => 2249, 'stock' => 280, 'status' => 'In Stock', 'badge' => 'emerald'],
        ['sku' => 'BAN-BROC-088', 'name' => 'Varanasi Pure Brocade Bridal Collection', 'category' => 'Banarasi Silk', 'mrp' => 7499, 'retail' => 4899, 'stock' => 65, 'status' => 'In Stock', 'badge' => 'emerald'],
        ['sku' => 'CHAN-ORG-104', 'name' => 'Festive Chanderi Organza Lightweight Saree', 'category' => 'Organza', 'mrp' => 3999, 'retail' => 2599, 'stock' => 190, 'status' => 'In Stock', 'badge' => 'emerald'],
        ['sku' => 'GEOR-PRT-042', 'name' => 'Jaipur Bandhani Digital Printed Georgette', 'category' => 'Georgette', 'mrp' => 2499, 'retail' => 1599, 'stock' => 12, 'status' => 'Low Stock', 'badge' => 'amber']
    ];
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
        ['id' => 'CART-8912', 'customer' => 'Meena Agarwal', 'phone' => '9820145821', 'items' => '1x Kanjeevaram Silk + 1x Organza', 'value' => 6498, 'created' => '22 Aug 2026, 03:10 PM', 'status' => 'High Intent', 'badge' => 'emerald'],
        ['id' => 'CART-8913', 'customer' => 'Sunita Verma', 'phone' => '9711288410', 'items' => '2x Surat Dola Silk Jacquard', 'value' => 4498, 'created' => '22 Aug 2026, 01:45 PM', 'status' => 'Payment Failed', 'badge' => 'crimson'],
        ['id' => 'CART-8914', 'customer' => 'Radha Krishnan', 'phone' => '9845033190', 'items' => '1x Banarasi Brocade Saree', 'value' => 4899, 'created' => '21 Aug 2026, 09:20 PM', 'status' => 'Dropped at Shipping', 'badge' => 'amber'],
        ['id' => 'CART-8915', 'customer' => 'Divya Sharma', 'phone' => '9904211560', 'items' => '1x Chanderi Festive Organza', 'value' => 2599, 'created' => '21 Aug 2026, 06:15 PM', 'status' => 'Active Cart', 'badge' => 'blue']
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
