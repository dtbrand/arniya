<?php
/**
 * DT Brand/account.php — Master Customer & Partner Portal Dashboard
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/OrderManager.php';
require_once __DIR__ . '/src/CustomerManager.php';

use DTBrand\OrderManager;
use DTBrand\CustomerManager;

$orders = OrderManager::getAll(['limit' => 10]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="View your DT Brand's account profile, live order tracking, wholesale invoices and reseller payout balance." />
    <title>My Account & Orders &bull; DT Brand's &bull; Jai Hanuman Tex</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/modals.css?v=<?= time() ?>">

    <style>
        .dt-acc-layout {
            max-width: 1200px;
            margin: 30px auto 50px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 24px;
        }
        @media (max-width: 768px) {
            .dt-acc-layout { grid-template-columns: 1fr; }
        }
        .dt-acc-sidebar {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 16px;
            height: fit-content;
        }
        .dt-acc-user-card {
            text-align: center;
            padding-bottom: 16px;
            border-bottom: 1px solid #F3F4F6;
            margin-bottom: 14px;
        }
        .dt-acc-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8A681F, #D4AF37);
            color: #FFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 auto 8px;
        }
        .dt-acc-nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 6px;
            color: #4B5563;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            margin-bottom: 4px;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .dt-acc-nav-link.active, .dt-acc-nav-link:hover {
            background: #FAF5E8;
            color: #8A681F;
            font-weight: 700;
        }
        .dt-acc-card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .dt-order-row-card {
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>

    <!-- Master Header with Amazon-Style Search & Attached Gold Subnav -->
    <?php include_once __DIR__ . '/includes/header.php'; ?>

    <main class="dt-acc-layout">
        
        <!-- Sidebar Profile Menu -->
        <aside class="dt-acc-sidebar">
            <div class="dt-acc-user-card">
                <div class="dt-acc-avatar" id="dtAccAvatar">P</div>
                <h3 style="font-size:1rem; font-weight:800; color:#111827;" id="dtAccName">Priya Sharma</h3>
                <span class="dt-trust-tag" id="dtAccType" style="margin-top:4px;">Wholesale Partner</span>
            </div>
            <nav>
                <button type="button" class="dt-acc-nav-link active" onclick="switchAccTab('orders')">
                    <span>📦 My Orders & Tracking</span>
                </button>
                <button type="button" class="dt-acc-nav-link" onclick="switchAccTab('profile')">
                    <span>👤 Partner Profile & GST</span>
                </button>
                <button type="button" class="dt-acc-nav-link" onclick="switchAccTab('addresses')">
                    <span>📍 Saved Delivery Addresses</span>
                </button>
                <button type="button" class="dt-acc-nav-link" onclick="switchAccTab('payouts')">
                    <span>💰 Reseller Commission & Payouts</span>
                </button>
                <button type="button" class="dt-acc-nav-link" style="color:#DC2626;" onclick="localStorage.removeItem('dtbrands_user'); window.location.href='/';">
                    <span>🚪 Log Out</span>
                </button>
            </nav>
        </aside>

        <!-- Main Account Content Area -->
        <div class="dt-acc-content">
            
            <!-- Orders Section -->
            <section class="dt-acc-card" id="dtAccOrdersSection">
                <h2 style="font-size:1.2rem; font-weight:800; color:#111827; margin-bottom:16px;">Recent Orders & Fulfillment Tracking</h2>
                
                <?php if (empty($orders)): ?>
                <div class="dt-empty-state">
                    <div class="dt-empty-icon">📦</div>
                    <h4 class="dt-empty-title">No Orders Yet</h4>
                    <p class="dt-empty-desc">Your order history will appear here once you place an order.</p>
                    <a href="/shop.php" class="dt-btn-gold">Start Shopping &rarr;</a>
                </div>
                <?php else: ?>
                    <?php foreach ($orders as $ord): ?>
                    <div class="dt-order-row-card">
                        <div>
                            <div style="font-size:0.88rem; font-weight:800; color:#111827;">Order #<?= htmlspecialchars($ord['order_number']) ?></div>
                            <div style="font-size:0.75rem; color:#6B7280;"><?= date('d M Y, h:i A', strtotime($ord['created_at'])) ?> &bull; <?= count($ord['items']) ?> Items</div>
                        </div>
                        <div>
                            <span class="dt-trust-tag" style="background:#DCFCE7; color:#15803D;"><?= ucfirst($ord['fulfillment_status']) ?></span>
                        </div>
                        <div>
                            <div style="font-size:0.95rem; font-weight:800; color:#8A681F;">₹<?= number_format($ord['total_amount']) ?></div>
                            <div style="font-size:0.72rem; color:#6B7280;"><?= strtoupper($ord['payment_method']) ?> (<?= ucfirst($ord['payment_status']) ?>)</div>
                        </div>
                        <div>
                            <a href="https://wa.me/919876543210?text=Hi%20DT%20Brands,%20please%20share%20tracking%20for%20Order%20<?= urlencode($ord['order_number']) ?>" target="_blank" rel="noopener" class="dt-btn-pale" style="font-size:0.75rem;">
                                <span>Track on WhatsApp</span>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

        </div>

    </main>

    <!-- Master Footer -->
    <?php include_once __DIR__ . '/includes/footer.php'; ?>

    <!-- Mobile Floating Bottom App Bar -->
    <?php include_once __DIR__ . '/includes/mobile_bottom_nav.php'; ?>

    <!-- Shared Modals (Cart, Wishlist, Checkout, Auth, QuickView, SmartShare, Reels) -->
    <?php include_once __DIR__ . '/shared/cart_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/wishlist_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/checkout_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/auth_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/quickview_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/smart_share_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/reels_modal.php'; ?>

    <!-- Master Scripts -->
    <script src="/assets/js/core.js?v=<?= time() ?>"></script>
    <script src="/assets/js/header.js?v=<?= time() ?>"></script>
    <script src="/assets/js/modals.js?v=<?= time() ?>"></script>

    <script>
        function switchAccTab(tab) {
            window.showToast('Switched to ' + tab + ' view');
        }

        // Load stored user if present
        try {
            var u = JSON.parse(localStorage.getItem('dtbrands_user') || 'null');
            if (u) {
                var nameEl = document.getElementById('dtAccName');
                var typeEl = document.getElementById('dtAccType');
                var avEl = document.getElementById('dtAccAvatar');
                if (nameEl) nameEl.textContent = u.name;
                if (typeEl) typeEl.textContent = (u.type ? u.type.toUpperCase() : 'RETAIL') + ' PARTNER';
                if (avEl) avEl.textContent = (u.name || 'U').charAt(0).toUpperCase();
            }
        } catch (e) {}
    </script>

</body>
</html>
