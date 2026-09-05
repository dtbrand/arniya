<?php
/**
 * shipping.php — DT Brand's & Jai Hanuman Tex
 * Luxury Master Shipping, Transport Logistics & Dispatch Policy
 */
require_once __DIR__ . '/src/Database.php';
use DTBrand\Database;

$contactSettings = [];
try {
    foreach (Database::query('SELECT key_name, `value` FROM settings WHERE key_name LIKE "contact_%"') as $r) {
        $contactSettings[$r['key_name']] = (string)$r['value'];
    }
} catch (\Throwable $e) {}

function getContactSetting(string $k, string $def, array $settings): string {
    $v = trim((string)($settings[$k] ?? ''));
    return $v !== '' ? $v : $def;
}

$showroomAddress = getContactSetting('contact_showroom_address', 'Ring Road, Surat Textile Market, Surat, Gujarat 395002', $contactSettings);
$whatsappHotline = getContactSetting('contact_whatsapp_hotline', '+91 70463 63528', $contactSettings);
$wholesaleLine   = getContactSetting('contact_wholesale_line', '+91 70463 63528', $contactSettings);
$supportEmail    = getContactSetting('contact_support_email', 'care@jaihanumantex.in', $contactSettings);
$businessHours   = getContactSetting('contact_business_hours', '10:00 AM – 8:00 PM IST (Mon–Sat)', $contactSettings);

$cleanPhone = preg_replace('/[^0-9]/', '', $whatsappHotline);
if (!$cleanPhone) {
    $cleanPhone = '917046363528';
}

$pageTitle = "Shipping & Logistics Policy — DT Brand's & Jai Hanuman Tex";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Surat loom factory dispatch timelines, surface transport networks, air express couriers, and insured logistics of DT Brand's." />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/home.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/policies.css?v=<?= time() ?>">
</head>
<body>

<?php include_once __DIR__ . '/includes/shophader.php'; ?>

<main class="dt-policy-wrapper">
    <!-- ════════════ MASTER LUXURY HERO BANNER ════════════ -->
    <section class="dt-policy-hero">
        <div class="dt-policy-hero-inner">
            <div class="dt-policy-breadcrumb">
                <a href="/">Home</a>
                <span class="sep">›</span>
                <span>Fulfillment &amp; Dispatch</span>
                <span class="sep">›</span>
                <span style="color:#FAF5E8;">Shipping &amp; Logistics</span>
            </div>

            <div class="dt-policy-badge">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                <span>Insured Nationwide Mill Logistics</span>
            </div>

            <h1 class="dt-policy-title">Shipping &amp; <span class="gold">Transport Logistics</span></h1>
            <p class="dt-policy-subtitle">Direct factory dispatch from Surat Textile Market with 100% insured transport coverage, real-time LR sharing, and express air delivery across 28,000+ Indian pincodes.</p>

            <div class="dt-policy-meta-strip">
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Dispatch Time: <strong>24–48 Hours</strong></span>
                </div>
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Coverage: <strong>100% Transit Insured</strong></span>
                </div>
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path></svg>
                    <span>Hub: <strong>Surat Central Logistics</strong></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ MAIN POLICY LAYOUT ════════════ -->
    <div class="dt-policy-main-wrap">
        <div class="dt-policy-layout">
            
            <!-- Sidebar Quick Jump -->
            <aside class="dt-policy-sidebar">
                <div class="dt-sidebar-heading">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke-width="2.5"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    <span>Logistics Navigation</span>
                </div>
                <ul class="dt-sidebar-nav">
                    <li><a href="#ship-1" class="active"><span>1. Dispatch Timelines</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#ship-2"><span>2. Surface &amp; Air Networks</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#ship-3"><span>3. Heavy Bale Transport &amp; LR</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#ship-4"><span>4. 100% In-Transit Insurance</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#ship-5"><span>5. Live WhatsApp Tracking</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#ship-6"><span>6. Non-Delivery &amp; RTO Rules</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                </ul>

                <div class="dt-sidebar-concierge">
                    <h4>Need Dispatch Status?</h4>
                    <p>Send your Order ID or LR Number to get real-time location updates.</p>
                    <a href="https://wa.me/<?= htmlspecialchars($cleanPhone) ?>?text=<?= urlencode("Hello DT Brand Logistics, I want to track my dispatch LR.") ?>" target="_blank" rel="noopener noreferrer" class="dt-btn-emerald" style="width:100%; box-sizing:border-box; font-size:0.75rem; padding:8px 12px; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>Track on WhatsApp</span>
                    </a>
                </div>
            </aside>

            <!-- Main Content Cards -->
            <div class="dt-policy-content">
                
                <!-- Card 1 -->
                <article class="dt-policy-card" id="ship-1">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">01</div>
                        <h2 class="dt-card-title">Dispatch Timelines &amp; Factory Fulfillment</h2>
                    </div>
                    <p>All consignments are packed and dispatched directly from our central manufacturing warehouse in the <strong>Surat Textile Market</strong>:</p>
                    <ul>
                        <li><strong>Ready Stock &amp; Catalog Pieces:</strong> Dispatched within <strong>24 to 48 business hours</strong> following order confirmation and verification.</li>
                        <li><strong>Bulk Wholesale Lots &amp; Master Bales:</strong> Packed in high-density moisture-resistant bale wraps and dispatched within <strong>2 to 4 working days</strong>.</li>
                        <li><strong>Custom Stitched / Bridal Customizations:</strong> Require <strong>4 to 7 working days</strong> for master artisan stitching and final QC inspection.</li>
                    </ul>

                    <div class="dt-policy-callout">
                        <div class="dt-callout-icon">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="dt-callout-text">
                            <strong>Daily 6:00 PM Mill Cutoff:</strong> Orders verified before 6:00 PM IST on working days are scheduled for immediate same-day or next-morning courier handover.
                        </div>
                    </div>
                </article>

                <!-- Card 2 -->
                <article class="dt-policy-card" id="ship-2">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">02</div>
                        <h2 class="dt-card-title">Accredited Courier &amp; Surface Transport Networks</h2>
                    </div>
                    <p>We work exclusively with Tier-1 logistics providers to ensure timely and damage-free transit:</p>
                    <ul>
                        <li><strong>Air Express Couriers:</strong> Delhivery, BlueDart, DTDC, XpressBees, and Shadowfax (Delivery within 2–4 business days across metro and Tier-1 cities).</li>
                        <li><strong>Heavy Surface Transporters:</strong> V-Trans, TCI Freight, SafeExpress, Patel Roadways, and South Eastern Roadways (Delivery within 4–7 business days for wholesale bales).</li>
                    </ul>
                </article>

                <!-- Card 3 -->
                <article class="dt-policy-card" id="ship-3">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">03</div>
                        <h2 class="dt-card-title">Wholesale Master Bale Logistics &amp; LR Copy</h2>
                    </div>
                    <p>For commercial volume buyers receiving consignments via Surat surface transport:</p>
                    <ul>
                        <li><strong>Lorry Receipt (LR) Handover:</strong> A high-resolution copy of the official transport Bilty / LR is uploaded to your account and forwarded via WhatsApp within <strong>3 hours of factory gate dispatch</strong>.</li>
                        <li><strong>Door Delivery vs Godown Delivery:</strong> Wholesalers can elect either doorstep unloading or local transport godown self-pickup based on regional vehicle access.</li>
                    </ul>
                </article>

                <!-- Card 4 -->
                <article class="dt-policy-card" id="ship-4">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">04</div>
                        <h2 class="dt-card-title">100% Comprehensive In-Transit Insurance</h2>
                    </div>
                    <p>Every commercial shipment dispatched by DT Brand's is backed by comprehensive in-transit transit risk coverage:</p>
                    <ul>
                        <li><strong>Complete Loss Protection:</strong> In the extraordinary circumstance of total parcel loss or transit damage caused by transport accidents, your order is 100% re-dispatched or refunded.</li>
                        <li><strong>Tamper-Proof Holographic Packaging:</strong> All parcels are sealed with DT Brand's security tamper tapes to eliminate mid-transit pilferage.</li>
                    </ul>
                </article>

                <!-- Card 5 -->
                <article class="dt-policy-card" id="ship-5">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">05</div>
                        <h2 class="dt-card-title">Live 24/7 WhatsApp Tracking &amp; LR Lookup</h2>
                    </div>
                    <p>Stay informed about every milestone of your parcel's journey:</p>
                    <p>Track your shipment directly via our automated WhatsApp concierge or speak with our dedicated Surat transport coordinator:</p>

                    <div class="dt-card-btn-row">
                        <a href="https://wa.me/<?= htmlspecialchars($cleanPhone) ?>?text=<?= urlencode("Hello DT Brand Logistics, please track my order.") ?>" target="_blank" rel="noopener noreferrer" class="dt-btn-emerald">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span>Live WhatsApp LR Track</span>
                        </a>
                        <a href="tel:<?= htmlspecialchars($cleanPhone) ?>" class="dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span>Call Logistics Desk: <?= htmlspecialchars($whatsappHotline) ?></span>
                        </a>
                    </div>
                </article>

                <!-- Card 6 -->
                <article class="dt-policy-card" id="ship-6">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">06</div>
                        <h2 class="dt-card-title">Non-Delivery, Address Correction &amp; RTO</h2>
                    </div>
                    <p>To avoid delivery delays, ensure complete destination addresses including landmark, district, and correct 6-digit postal pincode. In case of failed delivery attempts due to customer unavailability, carriers attempt re-delivery up to 3 times before initiating return to Surat.</p>
                </article>

            </div>

        </div>
    </div>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
