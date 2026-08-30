<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * brands/index.php — DT Brand's House Labels & Brand Suite (Wholesale Dashboard & Luxury Shop Standard)
 * DT Brand's & Jai Hanuman Tex
 *
 * Loads brand rows from the live `product_brands` table. The pre-migration
 * version of this page hard-coded three demo brands (DT Signature, Arniya
 * Heritage, DT Couture) in the HTML — they never reached the database and
 * the "Save" buttons silently failed. Everything on this page is now a
 * real write through /api/brands.php against the same table.
 */
require_once __DIR__ . '/../../../src/Database.php';
use DTBrand\Database;

$page_title = "Brands & House Labels";
$active_nav = "products";
$active_subnav = "brands";

$dbBrands = [];
$pdoBr = Database::getConnection();
if ($pdoBr !== null && !Database::isMockMode()) {
    try {
        $dbBrands = Database::query(
            'SELECT id, name, slug, description, logo_url, tier, status, created_at, updated_at
             FROM product_brands
             ORDER BY id ASC'
        );
    } catch (\Throwable $e) {
        $dbBrands = [];
    }
}

$brands = [];
foreach ($dbBrands as $r) {
    $initials = strtoupper(substr(preg_replace('/\s+/', '', (string)$r['name']), 0, 2));
    $brands[] = [
        'id' => (int)$r['id'],
        'name' => (string)$r['name'],
        'slug' => (string)($r['slug'] ?? ''),
        'description' => (string)($r['description'] ?? ''),
        'tier' => (string)($r['tier'] ?? 'Primary Flagship'),
        'status' => (string)($r['status'] ?? 'active'),
        'logo_url' => (string)($r['logo_url'] ?? ''),
        'initials' => $initials !== '' ? $initials : 'DT',
    ];
}

$activeCount = 0;
foreach ($brands as $b) {
    if ($b['status'] === 'active') {
        $activeCount++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands &amp; House Labels ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-ribbon {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }
    @media (max-width: 1024px) {
        .dt-kpi-ribbon { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .dt-kpi-ribbon { grid-template-columns: 1fr; }
    }
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 6px;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 3px 10px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .dt-brand-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #181512, #3D342A);
        color: #D4AF37;
        font-family: 'Cinzel', serif;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #D4AF37;
        box-shadow: 0 2px 8px rgba(212,175,55,0.25);
        flex-shrink: 0;
        overflow: hidden;
    }
    .dt-brand-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .dt-btn-action-pill {
        height: 28px;
        padding: 0 10px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dt-btn-action-pill:hover {
        transform: translateY(-1px);
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Brands &amp; House Labels</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;"><?= count($brands) ?> Live Labels</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products</span>
                    </a>
                    <a href="/admin/products/categories/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Categories</span>
                    </a>
                    <a href="/admin/products/attributes/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line></svg>
                        <span>Attributes</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddBrandModal()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Brand</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ACTIVE HOUSE LABELS</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;"><?= (int)$activeCount ?> Live Brands</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0-3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">CATALOG ASSIGNED SKUS</div>
                        <?php
                        $brAllProds = \DTBrand\ProductCatalog::getAll(true);
                        ?>
                        <div style="font-size:17px; font-weight:800; color:#15803D;"><?= count($brAllProds) ?> Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12M6 8h12"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">B2B CATALOG VALUATION</div>
                        <?php
                        $brVal = 0.0;
                        foreach ($brAllProds as $p) {
                            $brVal += ((int)($p['stock_qty'] ?? 0) * (float)($p['wholesale_price'] ?? 0));
                        }
                        $brValTxt = $brVal >= 100000
                            ? ('₹' . number_format($brVal / 100000, 2) . ' Lakhs')
                            : ('₹' . number_format($brVal, 2));
                        ?>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;"><?= $brValTxt ?></div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">SURAT CENTRAL READY STOCK</div>
                        <?php $brStock = array_sum(array_column($brAllProds, 'stock_qty')); ?>
                        <div style="font-size:17px; font-weight:800; color:#B45309;"><?= (int)$brStock ?> Units</div>
                    </div>
                </div>
            </div>

            <!-- 3. Brands Table — driven by /api/brands.php writes -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:8px; padding:14px; overflow-x:auto;">
                <table class="wp-list-table" id="brandsTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#FAF5E8; border-bottom:2px solid #D4AF37;">
                            <th style="width: 36px; padding:10px 8px;"><input type="checkbox" id="brandCheckAll" style="cursor:pointer;"></th>
                            <th style="width: 60px; padding:10px 8px;">Logo</th>
                            <th style="padding:10px 12px;">House Label &amp; Description</th>
                            <th style="padding:10px 10px;">Brand Tier</th>
                            <th style="padding:10px 10px;">Status</th>
                            <th style="width: 160px; text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="brandsTableBody">
                    <?php if (empty($brands)): ?>
                        <tr>
                            <td colspan="6" style="padding:24px; text-align:center; color:#64748B;">
                                No brands yet. Click <strong>Add Brand</strong> to create your first house label.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($brands as $b): ?>
                            <tr id="brand-row-<?= (int)$b['id'] ?>" style="border-bottom:1px solid #f0f0f1;">
                                <td style="text-align:center; padding:12px 8px;">
                                    <input type="checkbox" class="brand-row-check" value="<?= (int)$b['id'] ?>" style="cursor:pointer; width:15px; height:15px;">
                                </td>
                                <td style="padding:12px 10px;">
                                    <div class="dt-brand-avatar" id="brand-avatar-<?= (int)$b['id'] ?>">
                                        <?php if ($b['logo_url'] !== ''): ?>
                                            <img src="<?= htmlspecialchars($b['logo_url']) ?>" alt="">
                                        <?php else: ?>
                                            <?= htmlspecialchars($b['initials']) ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td style="padding:12px 12px;">
                                    <strong style="font-size:14px; color:#181512; display:block;" id="brand-title-<?= (int)$b['id'] ?>"><?= htmlspecialchars($b['name']) ?></strong>
                                    <span style="font-size:12px; color:#646970;" id="brand-tagline-<?= (int)$b['id'] ?>"><?= htmlspecialchars($b['description'] !== '' ? $b['description'] : 'No description yet') ?></span>
                                </td>
                                <td style="padding:12px 10px;">
                                    <span class="adm-badge gold" id="brand-tier-<?= (int)$b['id'] ?>"><?= htmlspecialchars($b['tier']) ?></span>
                                </td>
                                <td style="padding:12px 10px;">
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">
                                        <?= $b['status'] === 'active' ? 'Active & Live' : htmlspecialchars($b['status']) ?>
                                    </span>
                                </td>
                                <td style="padding:12px 12px; text-align:right;">
                                    <div style="display:flex; gap:5px; justify-content:flex-end;">
                                        <button type="button" class="dt-btn-action-pill" onclick="openEditBrandModal(<?= (int)$b['id'] ?>, '<?= htmlspecialchars(addslashes($b['name'])) ?>', '<?= htmlspecialchars(addslashes($b['tier'])) ?>', '<?= htmlspecialchars(addslashes($b['description'])) ?>', '<?= htmlspecialchars($b['initials']) ?>')" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            <span>Edit</span>
                                        </button>
                                        <button type="button" class="dt-btn-action-pill" onclick="deleteBrandRow(<?= (int)$b['id'] ?>)" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C;">
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#B91C1C" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: INSTANT EDIT BRAND & LOGO UPLOAD                  -->
<!-- ======================================================== -->
<div id="editBrandModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:540px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#D4AF37" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF;">Edit House Label: <span id="modalBrandTitleName" style="color:#FFE57F;"></span></h3>
            </div>
            <button type="button" onclick="closeEditBrandModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:18px 22px;">
            <input type="hidden" id="editModalBrandId" value="">

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="modalBrandName" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;" required>
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Tier</label>
                <select id="modalBrandTier" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
                    <option value="Primary Flagship">Primary Flagship</option>
                    <option value="Heritage Brocade">Heritage Brocade</option>
                    <option value="Bridal Luxury">Bridal Luxury</option>
                    <option value="Mill Volume B2B">Mill Volume B2B</option>
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Tagline / Manifesto</label>
                <input type="text" id="modalBrandTagline" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:14px 22px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeEditBrandModal()" style="height:34px; font-size:12px; font-weight:700; padding:0 14px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitEditBrandModal()" style="height:34px; font-size:12px; font-weight:800; padding:0 18px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Save &amp; Update Brand</span>
            </button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: ADD NEW HOUSE LABEL                                -->
<!-- ======================================================== -->
<div id="addBrandModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:540px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#D4AF37" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF;">Add New House Label</h3>
            </div>
            <button type="button" onclick="closeAddBrandModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:18px 22px;">
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="newBrandName" placeholder="e.g. Jai Hanuman Fab" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;" required>
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Tier</label>
                <select id="newBrandTier" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
                    <option value="Primary Flagship">Primary Flagship</option>
                    <option value="Heritage Brocade">Heritage Brocade</option>
                    <option value="Bridal Luxury">Bridal Luxury</option>
                    <option value="Mill Volume B2B">Mill Volume B2B</option>
                </select>
            </div>
            <div style="margin-bottom:10px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Tagline / Manifesto</label>
                <input type="text" id="newBrandTagline" placeholder="e.g. Surat Central Mill Direct Weaves" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:14px 22px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAddBrandModal()" style="height:34px; font-size:12px; font-weight:700; padding:0 14px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitNewBrand()" style="height:34px; font-size:12px; font-weight:800; padding:0 18px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Save &amp; Create Label</span>
            </button>
        </div>
    </div>
</div>

<script>
function openEditBrandModal(id, name, tier, tagline, initials) {
    document.getElementById('editModalBrandId').value = id;
    document.getElementById('modalBrandTitleName').textContent = name;
    document.getElementById('modalBrandName').value = name;
    document.getElementById('modalBrandTier').value = tier;
    document.getElementById('modalBrandTagline').value = tagline;
    const m = document.getElementById('editBrandModal');
    if (m) m.style.display = 'flex';
}

function closeEditBrandModal() {
    const m = document.getElementById('editBrandModal');
    if (m) m.style.display = 'none';
}

function submitEditBrandModal() {
    const id = document.getElementById('editModalBrandId').value;
    const name = document.getElementById('modalBrandName').value.trim();
    const tier = document.getElementById('modalBrandTier').value;
    const tagline = document.getElementById('modalBrandTagline').value.trim();
    if (!name) { return; }

    const params = new URLSearchParams();
    params.append('action', 'update');
    params.append('id', id);
    params.append('name', name);
    params.append('description', tagline);
    params.append('tier', tier);
    fetch('/api/brands.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(() => window.location.reload())
        .catch(() => window.location.reload());
}

function closeAddBrandModal() {
    const m = document.getElementById('addBrandModal');
    if (m) m.style.display = 'none';
}

function openAddBrandModal() {
    const m = document.getElementById('addBrandModal');
    if (m) m.style.display = 'flex';
}

function submitNewBrand() {
    const name = document.getElementById('newBrandName').value.trim();
    const tier = document.getElementById('newBrandTier').value;
    const tagline = document.getElementById('newBrandTagline').value.trim();
    if (!name) { return; }

    const params = new URLSearchParams();
    params.append('action', 'create');
    params.append('name', name);
    params.append('description', tagline);
    params.append('tier', tier);
    fetch('/api/brands.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(() => window.location.reload())
        .catch(() => window.location.reload());
}

function deleteBrandRow(id) {
    if (!confirm('Permanently delete this brand from the database?')) return;
    const params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);
    fetch('/api/brands.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(() => window.location.reload())
        .catch(() => window.location.reload());
}

document.addEventListener('DOMContentLoaded', function() {
    const all = document.getElementById('brandCheckAll');
    if (all) {
        all.addEventListener('change', function() {
            document.querySelectorAll('.brand-row-check').forEach(cb => { cb.checked = all.checked; });
        });
    }
});
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>