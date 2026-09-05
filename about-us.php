<?php
/**
 * about-us.php — DT Brand's & Jai Hanuman Tex
 * Luxury Master Brand Heritage, Surat Loom Direct Manufacturing & B2B Ecosystem
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

$pageTitle = "About Our Heritage — DT Brand's & Jai Hanuman Tex Surat";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Discover the artisanal handloom heritage of DT Brand's & Jai Hanuman Tex. Direct manufacturer and exporter of pure silk sarees in Surat Textile Market." />
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
                <span>Brand Story</span>
                <span class="sep">›</span>
                <span style="color:#FAF5E8;">About Our Heritage</span>
            </div>

            <div class="dt-policy-badge">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                <span>Surat Loom Direct Manufacturing</span>
            </div>

            <h1 class="dt-policy-title">Direct Mill Craftsmanship &amp; <span class="gold">Pure Silk Heritage</span></h1>
            <p class="dt-policy-subtitle">Three decades of artisanal handloom mastery, authentic Banarasi zari brocades, and transparent B2B mill pricing directly from the heart of Surat Textile Market.</p>

            <div class="dt-policy-meta-strip">
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Established: <strong>1994 (Surat, Gujarat)</strong></span>
                </div>
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>Loom Capacity: <strong>120+ Active Looms</strong></span>
                </div>
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span>Hub: <strong>Ring Road, Surat</strong></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ TWO-COLUMN CONTENT GRID ════════════ -->
    <div class="dt-policy-grid">
        
        <!-- MAIN EDITORIAL CONTENT -->
        <div class="dt-policy-content">

            <!-- Section 1: The Surat Legacy -->
            <article class="dt-policy-section">
                <div class="dt-section-badge">01</div>
                <h2 class="dt-section-title">The Surat Handloom Legacy</h2>
                <p>Founded at the epicenter of India's silk capital, <strong>DT Brand's &amp; Jai Hanuman Tex</strong> was born with a single founding mission: to bring the authentic artistry of pure jacquard weaving, rich zari brocades, and heritage bridal textiles directly from master weavers to retailers, boutiques, and saree connoisseurs worldwide.</p>
                <p>Over the last thirty years, our manufacturing facilities have expanded across Surat's premier textile corridor on Ring Road, combining generational weaving wisdom with precision high-speed rapier and electronic jacquard looms.</p>
                <div class="dt-callout-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#8A681F" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <div>
                        <strong>100% Genuine Mill Guarantee:</strong>
                        <span>Every warp, weft, and zari thread is woven in-house under strict quality supervision, ensuring zero counterfeit fabrics and uncompromised drape elegance.</span>
                    </div>
                </div>
            </article>

            <!-- Section 2: Direct-From-Mill Business Model -->
            <article class="dt-policy-section">
                <div class="dt-section-badge">02</div>
                <h2 class="dt-section-title">The Zero-Middleman Trade Advantage</h2>
                <p>Traditional textile supply chains often pass through four or five intermediaries—brokers, regional distributors, wholesale agents, and stockists—each adding markups of 15% to 35% before a saree reaches the store shelf. DT Brand's eliminates this friction entirely:</p>
                <ul class="dt-policy-list">
                    <li><strong>Direct Factory Pricing:</strong> Whether ordering a single bespoke bridal piece or a 500-saree wholesale master bale, buyers receive authentic mill-level rates.</li>
                    <li><strong>Bale Lot Quality Uniformity:</strong> Wholesale lots maintain strict dye-lot consistency, matched pallu finishing, and standardized 6.3m lengths with contrast unstitched blouse pieces.</li>
                    <li><strong>Rapid Order Turnaround:</strong> With ready inventories maintained in our Surat warehouses, approved wholesale and retailer orders dispatch within 24–48 hours.</li>
                </ul>
            </article>

            <!-- Section 3: Our Core Product Repertoire -->
            <article class="dt-policy-section">
                <div class="dt-section-badge">03</div>
                <h2 class="dt-section-title">Artisanal Textile Repertoire</h2>
                <p>Our seasonal lookbooks feature curated designs across the pinnacle of Indian ethnic textiles:</p>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin:20px 0;">
                    <div style="padding:16px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:8px;">
                        <strong style="color:#8A681F; font-size:0.95rem; display:block; margin-bottom:6px;">Pure Kanjivaram Bridal Silks</strong>
                        <span style="font-size:0.82rem; color:#645D54; line-height:1.5; display:block;">Heavy zari korvai borders, temple motifs, and heritage contrast pallus engineered for grand weddings.</span>
                    </div>
                    <div style="padding:16px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:8px;">
                        <strong style="color:#8A681F; font-size:0.95rem; display:block; margin-bottom:6px;">Authentic Banarasi Brocades</strong>
                        <span style="font-size:0.82rem; color:#645D54; line-height:1.5; display:block;">Intricate gold and antique zari jaal work woven on pure silk and katan blends with feathered borders.</span>
                    </div>
                    <div style="padding:16px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:8px;">
                        <strong style="color:#8A681F; font-size:0.95rem; display:block; margin-bottom:6px;">Contemporary Organza &amp; Chiffon</strong>
                        <span style="font-size:0.82rem; color:#645D54; line-height:1.5; display:block;">Lightweight luxury drapes featuring delicate scalloped borders, digital floral prints, and pearl accents.</span>
                    </div>
                </div>
            </article>

            <!-- Section 4: Nationwide B2B Ecosystem -->
            <article class="dt-policy-section">
                <div class="dt-section-badge">04</div>
                <h2 class="dt-section-title">A Modern Multi-Channel B2B Ecosystem</h2>
                <p>DT Brand's is more than a textile mill—it is a modern technology-enabled partner network supporting three primary B2B tiers:</p>
                <ul class="dt-policy-list">
                    <li><strong>Wholesale Partners:</strong> Volume lot buyers benefit from automatic tiered volume discounts (Half Bale 10+, Full Bale 50+, Master Lot 100+), GST invoice compliance, and flexible transport credit terms.</li>
                    <li><strong>Retail Store Owners:</strong> Brick-and-mortar boutique curators access MOQ flexibility, trending catalog previews, and fast express door delivery.</li>
                    <li><strong>Resellers &amp; Digital Entrepreneurs:</strong> Independent business owners access our 1-Click WhatsApp Smart Share catalogue generator, high-margin reseller pricing, and white-label drop shipping support.</li>
                </ul>
            </article>

        </div>

        <!-- SIDEBAR: ATELIER HIGHLIGHTS & FACTORY STATS -->
        <aside class="dt-policy-sidebar">

            <!-- Factory Overview Card -->
            <div class="dt-policy-card">
                <h3 class="dt-policy-card-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="9" y1="22" x2="9" y2="22.01"></line><line x1="15" y1="22" x2="15" y2="22.01"></line></svg>
                    <span>Mill At A Glance</span>
                </h3>
                
                <div style="display:flex; flex-direction:column; gap:12px; margin-top:14px; font-size:0.85rem;">
                    <div style="display:flex; justify-content:space-between; border-bottom:1px solid #E2E8F0; padding-bottom:8px;">
                        <span style="color:#64748B;">Headquarters:</span>
                        <strong style="color:#111827;">Surat, Gujarat</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; border-bottom:1px solid #E2E8F0; padding-bottom:8px;">
                        <span style="color:#64748B;">Manufacturing:</span>
                        <strong style="color:#111827;">120+ Active Looms</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; border-bottom:1px solid #E2E8F0; padding-bottom:8px;">
                        <span style="color:#64748B;">Monthly Output:</span>
                        <strong style="color:#111827;">50,000+ Sarees</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; border-bottom:1px solid #E2E8F0; padding-bottom:8px;">
                        <span style="color:#64748B;">Pincodes Served:</span>
                        <strong style="color:#111827;">28,000+ Across India</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:#64748B;">GSTIN Verified:</span>
                        <strong style="color:#111827;">24AAACR4920M1Z2</strong>
                    </div>
                </div>
            </div>

            <!-- Trade Quick Links -->
            <div class="dt-policy-card">
                <h3 class="dt-policy-card-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                    <span>Trade Portals</span>
                </h3>
                <div style="display:flex; flex-direction:column; gap:8px; margin-top:12px;">
                    <a href="/wholesale" class="dt-policy-side-link" style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; text-decoration:none; color:#181512; font-weight:700; font-size:12.5px;">
                        <span>Wholesale B2B Portal</span>
                        <span style="color:#8A681F;">›</span>
                    </a>
                    <a href="/retailer" class="dt-policy-side-link" style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; text-decoration:none; color:#181512; font-weight:700; font-size:12.5px;">
                        <span>Retailer Boutique Hub</span>
                        <span style="color:#8A681F;">›</span>
                    </a>
                    <a href="/reseller" class="dt-policy-side-link" style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; text-decoration:none; color:#181512; font-weight:700; font-size:12.5px;">
                        <span>Reseller Digital Passbook</span>
                        <span style="color:#8A681F;">›</span>
                    </a>
                </div>
            </div>

            <!-- Direct WhatsApp Factory Desk Card -->
            <div class="dt-policy-card dt-policy-cta-card" style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1.5px solid #8A681F; border-radius:12px; padding:22px; color:#FAF5E8;">
                <h3 style="font-family:'Cinzel',serif; color:#D4AF37; font-size:1.05rem; margin:0 0 8px 0;">Visit Our Surat Mill</h3>
                <p style="font-size:0.82rem; color:#E5E1D7; margin-bottom:14px; line-height:1.5;"><?= htmlspecialchars($showroomAddress) ?></p>
                <p style="font-size:0.8rem; color:#A8A29E; margin-bottom:16px;">Visiting hours: <?= htmlspecialchars($businessHours) ?></p>
                <a href="https://wa.me/<?= htmlspecialchars($cleanPhone) ?>?text=Namaste%20DT%20Brand%27s!%20I%20would%20like%20to%20inquire%20about%20visiting%20your%20Surat%20mill%20showroom." target="_blank" class="dt-btn-emerald" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%; text-decoration:none; padding:10px 16px; border-radius:8px; font-weight:800; font-size:13px; box-sizing:border-box;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="#FFFFFF"><path d="M12 2C6.48 2 2 6.48 2 12c0 1.95.56 3.77 1.53 5.31L2 22l4.82-1.5C8.32 21.46 10.1 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm5.42 14.19c-.23.64-1.32 1.25-1.84 1.32-.48.06-1.1.1-3.23-.78-2.56-1.06-4.22-3.66-4.35-3.83-.13-.17-1.04-1.38-1.04-2.63 0-1.25.66-1.86.89-2.12.23-.26.51-.32.68-.32.17 0 .34 0 .49.01.16.01.37-.06.58.44.22.53.75 1.83.82 1.96.07.13.11.29.02.47-.09.18-.14.29-.27.45-.13.16-.28.36-.4.48-.13.13-.26.28-.11.54.15.26.67 1.11 1.44 1.79.99.88 1.82 1.16 2.08 1.29.26.13.41.11.56-.06.15-.17.65-.76.82-1.02.17-.26.34-.22.58-.13.24.09 1.52.72 1.78.85.26.13.43.19.49.3.06.11.06.66-.17 1.3z"/></svg>
                    <span>Connect with Mill Desk</span>
                </a>
            </div>

        </aside>
    </div>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
<?php include_once __DIR__ . '/Shared/cart.php'; ?>
<?php include_once __DIR__ . '/Shared/wishlist.php'; ?>
<?php include_once __DIR__ . '/Shared/quickview.php'; ?>

</body>
</html>
