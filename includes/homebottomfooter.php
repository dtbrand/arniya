<?php
/**
 * homebottomfooter.php — SMART MOBILE BOTTOM FOOTER & RESELLER-STYLE MEGA MENU DRAWER
 * Luxury DT Brand Center Elevated Floating Reels Action Button with Animated HOT Badge
 * Luxury Reseller-style slide-in mobile navigation drawer & real vector menu SVG
 */
?>
<!-- ══════════════════════════════════════════════════════════════════
     SMART MOBILE BOTTOM FOOTER & RESELLER-STYLE MEGA MENU DRAWER
══════════════════════════════════════════════════════════════════ -->
<style>
/* ── Container & Floating Bottom Bar ── */
.home-smart-bottom-footer {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 99998 !important;
    padding: 0 12px;
    padding-bottom: max(8px, env(safe-area-inset-bottom, 8px));
    pointer-events: auto !important;
    transition: transform 0.32s cubic-bezier(0.34, 1.25, 0.64, 1), opacity 0.28s ease, visibility 0.28s ease;
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.home-smart-bottom-footer.is-hidden {
    transform: translateY(140%) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

/* Auto-hide via body classes when any overlay, drawer, sheet, or modal is active */
body.reels-open .home-smart-bottom-footer,
body.reels-modal-open .home-smart-bottom-footer,
body.modal-open .home-smart-bottom-footer,
body.cart-open .home-smart-bottom-footer,
body.wishlist-open .home-smart-bottom-footer,
body.drawer-open .home-smart-bottom-footer,
body.menu-open .home-smart-bottom-footer,
body.mf-open .home-smart-bottom-footer,
body.sort-open .home-smart-bottom-footer {
    transform: translateY(140%) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

@media (max-width: 1024px) {
    .home-smart-bottom-footer {
        display: block !important;
    }
    body {
        padding-bottom: 0 !important;
    }
}
@media (min-width: 1025px) {
    .home-smart-bottom-footer {
        display: none !important;
    }
}

@property --dt-border-angle {
    syntax: "<angle>";
    inherits: false;
    initial-value: 0deg;
}

@keyframes dtGoldPlatinumRun {
    to {
        --dt-border-angle: 360deg;
    }
}

.smart-nav-wrapper {
    position: relative;
    max-width: 440px;
    margin: 0 auto;
    border: 2px solid transparent !important;
    border-radius: 30px !important;
    background: linear-gradient(180deg, #221D18 0%, #14110E 100%) padding-box,
                conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
    animation: dtGoldPlatinumRun 2.5s linear infinite !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.55), 0 0 16px rgba(212, 175, 55, 0.35) !important;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    pointer-events: auto;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 0 4px;
    user-select: none;
    -webkit-user-select: none;
}

/* ── Standard Nav Item Links ── */
.smart-nav-item {
    position: relative;
    flex: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    padding-bottom: 9px;
    text-decoration: none;
    color: #A89F91;
    z-index: 5;
    transition: color 0.25s ease, transform 0.2s ease;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}

.smart-nav-icon-box {
    position: relative;
    width: 32px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 3px;
    transition: transform 0.25s ease, color 0.25s ease;
}

.smart-nav-svg {
    width: 22px;
    height: 22px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: all 0.25s ease;
}

.smart-nav-label {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
    transition: color 0.25s ease, font-weight 0.25s ease;
    opacity: 0.9;
    white-space: nowrap;
}

/* Hover & Active States for Standard Items (Color Transition Only) */
.smart-nav-item:hover,
.smart-nav-item:active,
.smart-nav-item.active {
    color: #F5D77F;
}

.smart-nav-item:hover .smart-nav-svg,
.smart-nav-item:active .smart-nav-svg,
.smart-nav-item.active .smart-nav-svg {
    stroke: #F5D77F;
    transform: translateY(-2px) scale(1.08);
}

.smart-nav-item.active .smart-nav-label {
    color: #F5D77F;
    font-weight: 800;
    opacity: 1;
}

/* Subtle Active Glowing Underline Dot */
.smart-nav-item.active::after {
    content: '';
    position: absolute;
    bottom: 3px;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #F5D77F;
    box-shadow: 0 0 6px #F5D77F;
}

/* ── PERMANENT HERO REELS BUTTON (Elevated Center Floating Bubble) ── */
.smart-nav-hero-reels {
    position: relative;
    flex: 1.15;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    padding-bottom: 7px;
    text-decoration: none;
    color: #F5D77F;
    z-index: 10;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}

.smart-hero-bubble {
    position: absolute;
    top: -20px;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #F5D77F 0%, #D4AF37 40%, #8A681F 100%);
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.55), 0 2px 8px rgba(0, 0, 0, 0.4), inset 0 2px 5px rgba(255, 255, 255, 0.5);
    border: 3.5px solid #181512;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.28s ease;
}

.smart-hero-bubble svg {
    width: 24px;
    height: 24px;
    stroke: #FFFFFF;
    stroke-width: 2.2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.35));
    animation: reelsPulse 2.4s infinite ease-in-out;
}

.smart-nav-hero-reels:hover .smart-hero-bubble,
.smart-nav-hero-reels:active .smart-hero-bubble {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 12px 28px rgba(212, 175, 55, 0.7), 0 4px 12px rgba(0, 0, 0, 0.5);
}

@keyframes reelsPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}

/* ── STYLED ANIMATED 🔥 HOT BADGE ── */
.smart-hero-hot-badge {
    position: absolute;
    top: -5px;
    right: -6px;
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #991B1B 100%);
    color: #FFFFFF;
    font-size: 0.48rem;
    font-weight: 900;
    letter-spacing: 0.05em;
    padding: 1.5px 5.5px;
    border-radius: 12px;
    border: 1.5px solid #181512;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6), 0 0 8px rgba(239, 68, 68, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 2px;
    z-index: 12;
    animation: hotBadgePulse 1.8s infinite ease-in-out;
    text-transform: uppercase;
}

@keyframes hotBadgePulse {
    0%, 100% { transform: scale(1); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6); }
    50% { transform: scale(1.14); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.85); }
}

.smart-nav-hero-label {
    font-size: 0.58rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
    color: #F5D77F;
    white-space: nowrap;
}

/* ── Live Wishlist Counter Badge ── */
.smart-nav-badge {
    position: absolute;
    top: -2px;
    right: -4px;
    background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
    color: #FFFFFF;
    font-size: 0.50rem;
    font-weight: 900;
    min-width: 15px;
    height: 15px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 3px;
    border: 1.5px solid #181512;
    box-shadow: 0 2px 6px rgba(220, 38, 38, 0.4);
    z-index: 6;
}

/* ══════════════════════════════════════════════════════════════════
   RESELLER-STYLE LUXURY MOBILE MEGA MENU DRAWER
══════════════════════════════════════════════════════════════════ */
.home-menu-drawer-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 12, 10, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 99999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.home-menu-drawer-backdrop.active {
    opacity: 1;
    visibility: visible;
}

.home-menu-drawer {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: min(85vw, 340px);
    background: #181512;
    background: linear-gradient(180deg, #1F1B16 0%, #14110E 100%);
    border-right: 1.5px solid rgba(212, 175, 55, 0.35);
    box-shadow: 10px 0 40px rgba(0, 0, 0, 0.6);
    z-index: 100000;
    transform: translateX(-100%);
    transition: transform 0.35s cubic-bezier(0.34, 1.25, 0.64, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.home-menu-drawer-backdrop.active .home-menu-drawer {
    transform: translateX(0);
}

/* Drawer Header with Logo & Close */
.home-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 14px;
    border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    background: rgba(0, 0, 0, 0.25);
}

.home-menu-logo {
    height: 32px;
    width: auto;
    object-fit: contain;
}

.home-menu-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(212, 175, 55, 0.3);
    color: #F5D77F;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.home-menu-close-btn:hover {
    background: rgba(212, 175, 55, 0.2);
    transform: rotate(90deg);
}

/* Scroll Content */
.home-menu-scroll {
    flex: 1;
    overflow-y: auto;
    padding: 12px 14px 24px;
    -webkit-overflow-scrolling: touch;
}

/* Reseller-Style VIP User Card */
.home-menu-user-card {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(30, 27, 24, 0.8) 100%);
    border: 1.2px solid rgba(212, 175, 55, 0.4);
    border-radius: 12px;
    padding: 10px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    transition: transform 0.2s ease;
}

.home-menu-user-card:hover {
    transform: translateY(-1px);
    border-color: #F5D77F;
    box-shadow: 0 6px 16px rgba(212, 175, 55, 0.2);
}

.home-menu-user-avatar-wrap {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1.5px solid #D4AF37;
    background: linear-gradient(135deg, #2A241E 0%, #181512 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.25);
    overflow: hidden;
}

.home-menu-user-avatar-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.home-menu-user-default-icon {
    stroke: #D4AF37;
}

.home-menu-user-info {
    flex: 1;
    min-width: 0;
}

.home-menu-user-name {
    font-size: 0.82rem;
    font-weight: 800;
    color: #FFFFFF;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.home-menu-user-tier {
    font-size: 0.62rem;
    font-weight: 700;
    color: #F5D77F;
    display: flex;
    align-items: center;
    gap: 3px;
    margin-top: 1px;
}

.home-menu-tier-badge {
    font-size: 0.58rem;
    font-weight: 900;
    background: linear-gradient(135deg, #D4AF37 0%, #8A681F 100%);
    color: #1E1B18;
    padding: 2px 6px;
    border-radius: 6px;
    letter-spacing: 0.04em;
    flex-shrink: 0;
}

/* Category Sections (Reseller TailAdmin Style) */
.home-menu-cat-title {
    font-size: 0.60rem;
    font-weight: 900;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #8A681F;
    margin: 14px 4px 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.home-menu-list {
    list-style: none;
    padding: 0;
    margin: 0 0 10px;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.home-menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 12px;
    border-radius: 10px;
    text-decoration: none;
    color: #D6CFC7;
    font-size: 0.78rem;
    font-weight: 700;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.home-menu-link:hover,
.home-menu-link.active {
    background: rgba(212, 175, 55, 0.12);
    border-color: rgba(212, 175, 55, 0.3);
    color: #F5D77F;
    transform: translateX(3px);
}

.home-menu-link svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
    transition: stroke 0.2s ease;
}

.home-menu-link-badge {
    margin-left: auto;
    font-size: 0.56rem;
    font-weight: 900;
    padding: 2px 6px;
    border-radius: 6px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.home-menu-link-badge.gold {
    background: linear-gradient(135deg, #F5D77F 0%, #D4AF37 100%);
    color: #1E1B18;
}

.home-menu-link-badge.hot {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: #FFFFFF;
}

.home-menu-link-badge.green {
    background: #10B981;
    color: #FFFFFF;
}

/* ── Category Accordions (Nested Sub-Category Style) ── */
.home-menu-accordions-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 8px;
}

.home-menu-accordion-item {
    border-radius: 10px;
    transition: background 0.25s ease, border-color 0.25s ease;
    border: 1px solid rgba(212, 175, 55, 0.12);
    background: rgba(255, 255, 255, 0.02);
    overflow: hidden;
}

.home-menu-accordion-item.open {
    background: rgba(212, 175, 55, 0.08);
    border-color: rgba(212, 175, 55, 0.35);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
}

.home-menu-accordion-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 12px;
    color: #E2DBD2;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    user-select: none;
    transition: all 0.2s ease;
    background: transparent;
    border: none;
    width: 100%;
    text-align: left;
    gap: 8px;
    box-sizing: border-box;
}

.home-menu-accordion-header:hover,
.home-menu-accordion-header.active,
.home-menu-accordion-item.open .home-menu-accordion-header {
    color: #F5D77F;
}

.home-menu-accordion-title {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 0;
}

.home-menu-accordion-title svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
}

.home-menu-accordion-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.home-menu-accordion-arrow {
    width: 15px;
    height: 15px;
    stroke: #D4AF37;
    stroke-width: 2.4;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform: rotate(0deg);
}

.home-menu-accordion-item.open .home-menu-accordion-arrow {
    transform: rotate(180deg);
    stroke: #F5D77F;
}

.home-menu-accordion-panel {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 0 10px 0 20px;
}

.home-menu-accordion-item.open .home-menu-accordion-panel {
    max-height: 520px;
    padding: 2px 10px 10px 18px;
}

.home-menu-sub-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 2px;
    border-left: 2px solid rgba(212, 175, 55, 0.35);
    padding-left: 8px;
}

.home-menu-sub-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 10px;
    border-radius: 6px;
    text-decoration: none;
    color: #C8C0B5;
    font-size: 0.74rem;
    font-weight: 600;
    transition: all 0.18s ease;
}

.home-menu-sub-link:hover,
.home-menu-sub-link.active {
    color: #F5D77F;
    background: rgba(212, 175, 55, 0.14);
    transform: translateX(3px);
}

.home-menu-sub-viewall {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 10px;
    margin-bottom: 4px;
    border-radius: 6px;
    text-decoration: none;
    color: #F5D77F;
    font-size: 0.70rem;
    font-weight: 800;
    background: rgba(212, 175, 55, 0.10);
    border: 1px solid rgba(212, 175, 55, 0.25);
    transition: all 0.18s ease;
}

.home-menu-sub-viewall:hover {
    background: rgba(212, 175, 55, 0.22);
    border-color: #F5D77F;
    transform: translateX(3px);
}

/* Footer Action */
.home-menu-footer {
    padding: 12px 14px;
    border-top: 1px solid rgba(212, 175, 55, 0.2);
    background: rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.home-menu-wa-btn {
    width: 100%;
    height: 38px;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #FFFFFF;
    border-radius: 10px;
    font-size: 0.74rem;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    transition: all 0.2s ease;
}

.home-menu-wa-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 211, 102, 0.45);
}
</style>

<!-- ════════════ RESELLER-STYLE HOME MEGA MENU DRAWER OVERLAY ════════════ -->
<?php
$drawerCategories = [];
if (class_exists('\DTBrand\ProductCatalog')) {
    $drawerCategories = \DTBrand\ProductCatalog::getCategoriesWithDetails();
}
if (empty($drawerCategories)) {
    $drawerCategories = [
        ['name' => 'Saree', 'slug' => 'saree', 'products_count' => '450'],
        ['name' => 'Lehenga', 'slug' => 'lehenga', 'products_count' => '120'],
        ['name' => 'Gown', 'slug' => 'gown', 'products_count' => '85'],
        ['name' => 'Kurti', 'slug' => 'kurti', 'products_count' => '160']
    ];
}

$drawerSubcategories = class_exists('\DTBrand\ProductCatalog') ? \DTBrand\ProductCatalog::getSubcategories() : [];
$categorySubMap = [];
if (!empty($drawerSubcategories)) {
    foreach ($drawerSubcategories as $dsc) {
        $cName = strtolower(trim((string)($dsc['category_name'] ?? '')));
        $cId = (int)($dsc['category_id'] ?? 0);
        if ($cName !== '') {
            $categorySubMap[$cName][] = $dsc;
        }
        if ($cId > 0) {
            $categorySubMap['id_' . $cId][] = $dsc;
        }
    }
}

$defaultCategorySubs = [
    'saree' => [
        ['name' => 'Banarasi Kadwa Silk', 'badge' => 'ROYAL', 'badge_cls' => 'gold'],
        ['name' => 'Bandhani & Patola Heritage', 'badge' => 'HERITAGE', 'badge_cls' => 'gold'],
        ['name' => 'Chanderi Cotton Silk', 'badge' => 'HANDLOOM', 'badge_cls' => 'green'],
        ['name' => 'Kanjivaram Pure Zari', 'badge' => 'PURE ZARI', 'badge_cls' => 'gold'],
        ['name' => 'Pure Organza Tissue', 'badge' => 'TRENDING', 'badge_cls' => 'gold'],
        ['name' => 'Yeola Paithani Brocade', 'badge' => 'CLASSIC', 'badge_cls' => 'green'],
    ],
    'lehenga' => [
        ['name' => 'Bridal Velvet Lehengas', 'badge' => 'BRIDAL', 'badge_cls' => 'gold'],
        ['name' => 'Organza Floral Lehengas', 'badge' => 'FLORAL', 'badge_cls' => 'green'],
        ['name' => 'Georgette Festive Lehengas', 'badge' => 'FESTIVE', 'badge_cls' => 'gold'],
        ['name' => 'Silk Heritage Chaniya Choli', 'badge' => 'HERITAGE', 'badge_cls' => 'green'],
    ],
    'gown' => [
        ['name' => 'Anarkali Silhouette Gowns', 'badge' => 'ROYAL', 'badge_cls' => 'gold'],
        ['name' => 'Floor-Length Georgette Gowns', 'badge' => 'ELEGANT', 'badge_cls' => 'green'],
        ['name' => 'Indo-Western Drape Gowns', 'badge' => 'PARTY', 'badge_cls' => 'gold'],
        ['name' => 'Embroidered Silk Gowns', 'badge' => 'NEW', 'badge_cls' => 'green'],
    ],
    'kurti' => [
        ['name' => '3-Piece Festive Kurti Sets', 'badge' => 'SETS', 'badge_cls' => 'gold'],
        ['name' => 'Flared Anarkali & Angrakha', 'badge' => 'FLARED', 'badge_cls' => 'gold'],
        ['name' => 'Pure Cotton Daily Kurtis', 'badge' => 'COMFORT', 'badge_cls' => 'green'],
        ['name' => 'Straight Cut Office Wear', 'badge' => 'DAILY', 'badge_cls' => 'green'],
    ]
];

$currentScript = basename($_SERVER['PHP_SELF'] ?? '');
$currentCatParam = $_GET['category'] ?? ($_GET['cat'] ?? '');
$currentSubParam = $_GET['subcategory'] ?? ($_GET['sub'] ?? '');
?>
<div class="home-menu-drawer-backdrop" id="homeMenuDrawerBackdrop" onclick="toggleHomeMobileMenu(false)">
    <aside class="home-menu-drawer" id="homeMenuDrawer" onclick="event.stopPropagation()">
        <!-- Header with Brand Logo & Close Button -->
        <div class="home-menu-header">
            <a href="/" style="display:flex; align-items:center;">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/assets/images/logo.png';" alt="DT Brand's" class="home-menu-logo">
            </a>
            <button class="home-menu-close-btn" onclick="toggleHomeMobileMenu(false)" aria-label="Close Menu">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Scrollable Navigation Area -->
        <div class="home-menu-scroll">
            <!-- Dynamic VIP User Card -->
            <div class="home-menu-user-card" id="homeMenuUserCard" onclick="toggleHomeMobileMenu(false); window.location.href='/account.php';">
                <div class="home-menu-user-avatar-wrap">
                    <svg class="home-menu-user-default-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#D4AF37" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div class="home-menu-user-info">
                    <div class="home-menu-user-name" id="homeMenuUserName">Welcome Guest Shopper</div>
                    <div class="home-menu-user-tier" id="homeMenuUserTier">
                        <span>★ Tap to Sign In / Register</span>
                    </div>
                </div>
                <span class="home-menu-tier-badge" id="homeMenuTierBadge">SIGN IN</span>
            </div>

            <!-- SECTION 1: STOREFRONT & WEAVES -->
            <div class="home-menu-cat-title">
                <span>STOREFRONT &amp; ALL PRODUCTS</span>
                <span style="font-size:0.52rem; color:#D4AF37; font-weight:800;">CATALOG</span>
            </div>
            <ul class="home-menu-list">
                <li>
                    <a href="/" class="home-menu-link <?= ($currentScript === 'index.php' || $currentScript === 'home.php' || $currentScript === '') ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Home Storefront</span>
                    </a>
                </li>
                <li>
                    <a href="/shop.php" class="home-menu-link <?= ($currentScript === 'shop.php' && empty($currentCatParam)) ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span>All Products Shop</span>
                        <span class="home-menu-link-badge gold">ALL</span>
                    </a>
                </li>
            </ul>

            <!-- CATEGORY-WISE ACCORDION MODULE -->
            <div class="home-menu-cat-title" style="margin-top:14px;">
                <span>SHOP BY CATEGORY &amp; WEAVE</span>
                <span style="font-size:0.52rem; color:#D4AF37; font-weight:800;">TAP TO EXPAND</span>
            </div>
            <div class="home-menu-accordions-group">
                <?php 
                $catIconMap = [
                    'saree' => '<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
                    'lehenga' => '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polygon points="12 6 12 12 16 14"></polygon></svg>',
                    'gown' => '<svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>',
                    'kurti' => '<svg viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg>'
                ];

                foreach ($drawerCategories as $dc): 
                    $dcName = $dc['name'] ?? '';
                    if ($dcName === '' || strtolower($dcName) === 'all') continue;
                    $dcSlug = strtolower($dc['slug'] ?? $dcName);
                    $isDActive = (strtolower($currentCatParam) === strtolower($dcName) || strtolower(str_replace('-', ' ', $currentCatParam)) === strtolower($dcName));
                    $dcBadge = (int)($dc['products_count'] ?? 0) > 0 ? (int)$dc['products_count'] . '+' : 'COLLECTION';
                    $iconSvg = $catIconMap[$dcSlug] ?? '<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';
                    
                    // Match subcategories
                    $subs = $categorySubMap[$dcSlug] ?? ($categorySubMap[strtolower($dcName)] ?? ($defaultCategorySubs[$dcSlug] ?? []));
                    $hasSubs = !empty($subs);
                ?>
                <div class="home-menu-accordion-item <?= ($isDActive && $hasSubs) ? 'open' : '' ?>">
                    <div class="home-menu-accordion-header <?= $isDActive ? 'active' : '' ?>" onclick="<?= $hasSubs ? 'toggleMenuAccordion(this)' : 'window.location.href=\'/shop.php?category=' . urlencode($dcName) . '\'' ?>">
                        <div class="home-menu-accordion-title">
                            <?= $iconSvg ?>
                            <span><?= htmlspecialchars($dcName) ?> Collection</span>
                        </div>
                        <div class="home-menu-accordion-meta">
                            <span class="home-menu-link-badge gold"><?= htmlspecialchars($dcBadge) ?></span>
                            <?php if ($hasSubs): ?>
                            <svg class="home-menu-accordion-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($hasSubs): ?>
                    <div class="home-menu-accordion-panel">
                        <ul class="home-menu-sub-list">
                            <li>
                                <a href="/shop.php?category=<?= urlencode($dcName) ?>" class="home-menu-sub-viewall">
                                    <span>✦ View All <?= htmlspecialchars($dcName) ?> Designs</span>
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                            </li>
                            <?php foreach ($subs as $subItem): 
                                $subName = $subItem['name'] ?? '';
                                if ($subName === '') continue;
                                $isSubActive = (strtolower($currentSubParam) === strtolower($subName));
                                $subBadge = $subItem['badge'] ?? '';
                                $subBadgeCls = $subItem['badge_cls'] ?? 'gold';
                            ?>
                            <li>
                                <a href="/shop.php?category=<?= urlencode($dcName) ?>&subcategory=<?= urlencode($subName) ?>" class="home-menu-sub-link <?= $isSubActive ? 'active' : '' ?>">
                                    <span>• <?= htmlspecialchars($subName) ?></span>
                                    <?php if ($subBadge !== ''): ?>
                                    <span class="home-menu-link-badge <?= $subBadgeCls ?>" style="font-size:0.50rem; padding:1px 5px;"><?= htmlspecialchars($subBadge) ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- VIDEO REELS LINK -->
            <ul class="home-menu-list" style="margin-top:10px;">
                <li>
                    <a href="javascript:void(0)" onclick="toggleHomeMobileMenu(false); if(typeof window.openReelsModal==='function') window.openReelsModal(0);" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="4"></rect><line x1="2" y1="8" x2="22" y2="8"></line><polygon points="10 12 15 15 10 18" fill="currentColor"></polygon></svg>
                        <span>Video Reels Stream</span>
                        <span class="home-menu-link-badge hot">🔥 HOT</span>
                    </a>
                </li>
            </ul>

            <!-- SECTION 2: B2B & PARTNER HUB -->
            <div class="home-menu-cat-title">
                <span>B2B &amp; WHOLESALE DESK</span>
                <span style="font-size:0.52rem; color:#10B981; font-weight:800;">DIRECT MILL</span>
            </div>
            <ul class="home-menu-list">
                <li>
                    <a href="/wholesale.php" class="home-menu-link <?= ($currentScript === 'wholesale.php') ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        <span>Wholesale Bulk Factory Hub</span>
                        <span class="home-menu-link-badge green">SLABS</span>
                    </a>
                </li>
                <li>
                    <a href="/reseller.php" class="home-menu-link <?= ($currentScript === 'reseller.php') ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Zero-Investment Reseller Hub</span>
                        <span class="home-menu-link-badge gold">VIP EARN</span>
                    </a>
                </li>
                <li>
                    <a href="/retailer.php" class="home-menu-link <?= ($currentScript === 'retailer.php') ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Boutique &amp; Retailer Desk</span>
                        <span class="home-menu-link-badge gold">GST BILL</span>
                    </a>
                </li>
                <li>
                    <a href="/contact.php" class="home-menu-link <?= ($currentScript === 'contact.php') ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Contact Atelier &amp; Factory</span>
                        <span class="home-menu-link-badge green">SURAT</span>
                    </a>
                </li>
            </ul>

            <!-- SECTION 3: ACCOUNT & POLICIES -->
            <div class="home-menu-cat-title">
                <span>ACCOUNT &amp; SUPPORT</span>
            </div>
            <ul class="home-menu-list">
                <li>
                    <a href="javascript:void(0)" onclick="toggleHomeMobileMenu(false); if(typeof openWishlistDrawer==='function') openWishlistDrawer();" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        <span>Saved Masterpieces</span>
                        <span class="home-menu-link-badge gold" id="homeDrawerWishlistBadge" style="display:none;">0</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="toggleHomeMobileMenu(false); if(typeof openCartDrawer==='function') openCartDrawer();" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>My Shopping Bag</span>
                    </a>
                </li>
                <li>
                    <a href="/account.php" onclick="toggleHomeMobileMenu(false);" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>My Account &amp; Orders</span>
                    </a>
                </li>
                <li>
                    <a href="/shipping.php" class="home-menu-link <?= ($currentScript === 'shipping.php') ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Shipping &amp; Logistics</span>
                    </a>
                </li>
                <li>
                    <a href="/terms.php" class="home-menu-link <?= ($currentScript === 'terms.php') ? 'active' : '' ?>">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Terms of Wholesale</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Footer Action (WhatsApp Concierge) -->
        <div class="home-menu-footer">
            <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20I%20need%20assistance%20with%20DT%20Brand%20catalog." target="_blank" class="home-menu-wa-btn">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="#FFFFFF"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                <span>WhatsApp Stylist Concierge</span>
                <span style="font-size:0.52rem; background:rgba(255,255,255,0.25); padding:1px 5px; border-radius:8px; font-weight:900;">LIVE 24/7</span>
            </a>
        </div>
    </aside>
</div>

<!-- ════════════ BOTTOM FIXED FLOATING BAR ════════════ -->
<nav class="home-smart-bottom-footer" id="homeSmartBottomFooter" aria-label="Mobile Bottom Navigation">
    <div class="smart-nav-wrapper" id="smartNavWrapper">

        <!-- 1: MENU / DRAWER (Real Vector Menu SVG with 3-Line Tier Icon) -->
        <a href="javascript:void(0)" class="smart-nav-item" id="smartNavMenu" data-tab="menu" onclick="handleSmartFooterAction(event, '', 'menu')" aria-label="Open Mobile Menu Drawer">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="16" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
            <span class="smart-nav-label">Menu</span>
        </a>

        <!-- 2: SHOP / BOUTIQUE STORE (Real Storefront Canopy SVG) -->
        <a href="/shop" class="smart-nav-item" id="smartNavShop" data-tab="shop" onclick="handleSmartFooterAction(event, '/shop.php', 'shop')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M3 9l1-5h16l1 5"></path>
                    <path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"></path>
                    <path d="M4 14v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6"></path>
                    <path d="M10 22v-6h4v6"></path>
                </svg>
            </div>
            <span class="smart-nav-label">Shop</span>
        </a>

        <!-- 3: PERMANENT HERO REELS (Elevated Center Floating Bubble with 🔥 HOT Badge) -->
        <a href="javascript:void(0)" class="smart-nav-hero-reels" id="smartNavReels" data-tab="reels" onclick="handleSmartFooterAction(event, '', 'reels')" aria-label="Watch Video Reels">
            <div class="smart-hero-bubble">
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="18" rx="4"></rect>
                    <line x1="2" y1="8" x2="22" y2="8"></line>
                    <line x1="7" y1="3" x2="5" y2="8"></line>
                    <line x1="13" y1="3" x2="11" y2="8"></line>
                    <line x1="19" y1="3" x2="17" y2="8"></line>
                    <polygon points="10 12 15 15 10 18" fill="currentColor"></polygon>
                </svg>
                <!-- Animated Glowing 🔥 HOT Badge -->
                <span class="smart-hero-hot-badge">🔥 HOT</span>
            </div>
            <span class="smart-nav-hero-label">Reels</span>
        </a>

        <!-- 4: WISHLIST (Slide-over Drawer) -->
        <a href="javascript:void(0)" class="smart-nav-item" id="smartNavWishlist" data-tab="wishlist" onclick="handleSmartFooterAction(event, '', 'wishlist')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="smart-nav-badge" id="smartWishlistBadge">0</span>
            </div>
            <span class="smart-nav-label">Wishlist</span>
        </a>

        <!-- 5: MY ACCOUNT / ORDERS (Direct Role-Based Dashboard or Login Modal) -->
        <a href="javascript:void(0)" class="smart-nav-item" id="smartNavAccount" data-tab="account" onclick="handleSmartFooterAction(event, '', 'account')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <span class="smart-nav-label">Account</span>
        </a>

    </div>
</nav>

<script>
(function() {
    // Toggle Reseller-style Home Mobile Menu Drawer
    window.toggleHomeMobileMenu = function(show) {
        var backdrop = document.getElementById('homeMenuDrawerBackdrop');
        if (!backdrop) return;
        if (typeof show === 'undefined') {
            backdrop.classList.toggle('active');
        } else if (show) {
            backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
            syncDrawerUserState();
        } else {
            backdrop.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    // Toggle Category Accordion Submenu
    window.toggleMenuAccordion = function(headerElem) {
        if (!headerElem) return;
        var item = headerElem.closest('.home-menu-accordion-item');
        if (!item) return;
        var isOpen = item.classList.contains('open');
        item.classList.toggle('open', !isOpen);
    };

    window.handleSmartFooterAction = function(e, targetUrl, actionKey) {
        // 1. MENU ACTION (Open Reseller-Style Mega Menu Drawer)
        if (actionKey === 'menu') {
            if (e) e.preventDefault();
            window.toggleHomeMobileMenu(true);
            return;
        }

        // 2. REELS ACTION (Open Fullscreen Reels Player)
        if (actionKey === 'reels') {
            if (e) e.preventDefault();
            if (typeof window.openReelsModal === 'function') {
                window.openReelsModal(0);
            } else {
                var reelSec = document.getElementById('section-reels');
                if (reelSec) reelSec.scrollIntoView({ behavior: 'smooth' });
            }
            return;
        }

        // 3. WISHLIST ACTION (Open Slide-over Drawer)
        if (actionKey === 'wishlist') {
            if (e) e.preventDefault();
            if (typeof window.openWishlistDrawer === 'function') {
                window.openWishlistDrawer();
            } else if (typeof window.openWishlistModal === 'function') {
                window.openWishlistModal();
            } else if (typeof window.openWishlist === 'function') {
                window.openWishlist();
            } else {
                window.location.href = '/wishlist.php';
            }
            return;
        }

        // 4. MY ACCOUNT ACTION (Direct to Master Account Hub)
        if (actionKey === 'account') {
            if (e) e.preventDefault();
            window.location.href = '/account.php';
            return;
        }

        // 5. PAGE NAVIGATION (Smooth scroll to top if already on page)
        var currentPath = window.location.pathname;
        if (targetUrl && (currentPath.endsWith(targetUrl) || (actionKey === 'shop' && currentPath.indexOf('shop.php') !== -1))) {
            if (e) e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
    };

    // Live Wishlist Counter Synchronizer
    function syncSmartWishlistCounter() {
        try {
            var wishlist = JSON.parse(localStorage.getItem('dt_wishlist') || localStorage.getItem('dtbrands_wishlist') || '[]');
            var count = Array.isArray(wishlist) ? wishlist.length : 0;
            var badge = document.getElementById('smartWishlistBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        } catch(err) {}
    }

    // Sync Drawer User Name, Role & Tier
    function syncDrawerUserState() {
        var userRaw = localStorage.getItem('dtbrands_user') || localStorage.getItem('dt_user');
        var nameEl = document.getElementById('homeMenuUserName');
        var tierEl = document.getElementById('homeMenuUserTier');
        var badgeEl = document.getElementById('homeMenuTierBadge');
        var avatarWrap = document.querySelector('.home-menu-user-avatar-wrap');
        if (userRaw && nameEl) {
            try {
                var user = JSON.parse(userRaw);
                var uName = user.name || user.full_name || 'VIP Member';
                nameEl.textContent = uName;
                var role = user.role || 'Member';
                if (tierEl) tierEl.innerHTML = '<span>★ Verified ' + (role.charAt(0).toUpperCase() + role.slice(1)) + '</span>';
                if (badgeEl) badgeEl.textContent = role.toUpperCase();
                if (avatarWrap && user.avatar) {
                    avatarWrap.innerHTML = '<img src="' + user.avatar + '" alt="' + uName + '" onerror="this.onerror=null; this.src=\'/assets/images/product1.png\';">';
                }
            } catch(e) {}
        } else if (nameEl) {
            nameEl.textContent = 'Welcome Guest Shopper';
            if (tierEl) tierEl.innerHTML = '<span>★ Tap to Sign In / Register</span>';
            if (badgeEl) badgeEl.textContent = 'SIGN IN';
        }
    }

    // Active page highlighter
    function initActivePageTab() {
        var currentPath = window.location.pathname;
        var items = document.querySelectorAll('.smart-nav-item');
        items.forEach(function(item) {
            var tab = item.getAttribute('data-tab');
            var isCurrent = false;
            if (tab === 'home' && (currentPath === '/' || currentPath.endsWith('/') || currentPath.indexOf('home.php') !== -1)) isCurrent = true;
            if (tab === 'shop' && currentPath.indexOf('shop.php') !== -1) isCurrent = true;

            item.classList.toggle('active', isCurrent);
        });

        syncSmartWishlistCounter();
        syncDrawerUserState();
        window.addEventListener('storage', function() {
            syncSmartWishlistCounter();
            syncDrawerUserState();
        });
    }

    window.syncSmartWishlistCounter = syncSmartWishlistCounter;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initActivePageTab);
    } else {
        initActivePageTab();
    }
})();
</script>
