<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * attributes/index.php — DT Brand's Master Textile Attributes & Taxonomies
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous revision rendered a hard-coded four-attribute array ("Color
 * Variations — 840 SKUs", "1,240 Products", "45 Swatches / Terms") with KPIs
 * from nowhere. Its Add/Edit/Delete did POST to /api/attributes.php but the
 * table never re-read the database, so saved attributes never appeared,
 * deleted ones resurrected on reload, and Configure Terms bounced back for
 * ids that only existed in the fake array. Every row now comes from the live
 * product_attributes table and every action reloads on completion.
 */
require_once __DIR__ . '/../../../src/Database.php';
require_once __DIR__ . '/../../../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$page_title = "Attributes Management";
$active_nav = "products";
$active_subnav = "attributes";

$attributes_list = [];
$totalTerms = 0;

$pdoAttr = Database::getConnection();
if ($pdoAttr !== null && !Database::isMockMode()) {
    try {
        $rows = Database::query(
            'SELECT id, name, slug, type, values_json, created_at, updated_at
             FROM product_attributes
             ORDER BY id ASC'
        );
        foreach ($rows as $r) {
            $terms = json_decode((string)($r['values_json'] ?? '[]'), true);
            if (!is_array($terms)) {
                $terms = [];
            }
            $totalTerms += count($terms);
            $attributes_list[] = [
                'id' => (int)$r['id'],
                'name' => (string)$r['name'],
                'slug' => (string)$r['slug'],
                'type' => (string)($r['type'] ?? 'Text Badge / Pill'),
                'values' => $terms,
                'created_at' => (string)($r['created_at'] ?? ''),
            ];
        }
    } catch (\Throwable $e) {
        $attributes_list = [];
    }
}

$totalProducts = count(ProductCatalog::getAll(true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attributes Management ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-ribbon {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }
    @media (max-width: 1024px) { .dt-kpi-ribbon { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .dt-kpi-ribbon { grid-template-columns: 1fr; } }
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
    .dt-attr-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11.5px;
        background: #f6f7f7;
        border: 1px solid #e2e8f0;
        color: #181512;
    }
    .dt-color-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.15);
        display: inline-block;
    }
    .dt-action-pill {
        height: 28px;
        padding: 0 9px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
    }
    .dt-action-pill:hover { transform: translateY(-1px); }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Textile Attributes Studio</h1>
                    <span class="adm-badge gold" id="kpiBadgeTotal" style="font-weight:700; font-size:11px; padding:3px 8px;"><?php echo count($attributes_list); ?> Live Taxonomies</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products</span>
                    </a>
                    <a href="/admin/products/variants/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#1D4ED8" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Variants Matrix</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddAttributeModal()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Attribute</span>
                    </button>
                </div>
            </div>

            <!-- 2. KPI Ribbon — live counts -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 21v-7m0-4V3m8 18v-9m0-4V3m8 18v-5m0-4V3M1 14h6m2-6h6m2 8h6"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ACTIVE ATTRIBUTES</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;" id="kpiActiveAttrs"><?php echo count($attributes_list); ?> Global Sets</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">TOTAL VARIATION TERMS</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;"><?php echo (int)$totalTerms ?> Saved</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">CATALOG PRODUCTS</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;"><?php echo (int)$totalProducts ?></div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">STORAGE</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">product_attributes</div>
                    </div>
                </div>
            </div>

            <!-- 3. Toolbar -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="attrBulkActionSelect" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">Bulk actions</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleAttrBulkAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>
                </div>

                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <input type="text" id="attrSearchInput" class="wp-search-input" placeholder="Search attributes, swatches..." style="height:34px; padding-left:12px; width:240px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchAttributes(this.value)">
                </div>
            </div>

            <!-- 4. Attributes Table — live rows -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="attributesTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width:36px; text-align:center; padding:10px 8px;">
                                <input type="checkbox" id="masterCheckbox" onchange="toggleSelectAllAttrs(this)" style="cursor:pointer;">
                            </th>
                            <th style="width:180px; padding:10px 12px;">Attribute Name &amp; Slug</th>
                            <th style="padding:10px 10px;">Display Type</th>
                            <th style="padding:10px 12px;">Configured Swatches / Values</th>
                            <th style="width:110px; padding:10px 10px;">Terms</th>
                            <th style="width:190px; text-align:right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="attributesTableBody">
                        <?php if (empty($attributes_list)): ?>
                            <tr><td colspan="6" style="padding:24px; text-align:center; color:#64748B;">No attributes defined yet. Click <strong>Add Attribute</strong> to create the first taxonomy (e.g. Color Variations, Fabric &amp; Material).</td></tr>
                        <?php else: ?>
                            <?php foreach ($attributes_list as $attr): ?>
                            <tr id="attr-row-<?= (int)$attr['id'] ?>" style="border-bottom:1px solid #f0f0f1;">
                                <td style="text-align:center; padding:12px 8px;">
                                    <input type="checkbox" class="attr-row-check" value="<?= (int)$attr['id'] ?>" style="cursor:pointer;">
                                </td>
                                <td style="padding:12px 12px;">
                                    <strong style="font-size:13.5px; color:#181512; display:block; margin-bottom:2px;"><?= htmlspecialchars($attr['name']) ?></strong>
                                    <code style="font-size:11px; color:#646970; background:#f0f0f1; padding:1px 5px; border-radius:3px;"><?= htmlspecialchars($attr['slug']) ?></code>
                                </td>
                                <td style="padding:12px 10px;">
                                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:11px; font-weight:700;"><?= htmlspecialchars($attr['type']) ?></span>
                                </td>
                                <td style="padding:12px 12px;">
                                    <div style="display:flex; flex-wrap:wrap; gap:4px;">
                                        <?php $shown = array_slice($attr['values'], 0, 6); ?>
                                        <?php foreach ($shown as $val): ?>
                                        <span class="dt-attr-chip">
                                            <?php $hex = (string)($val['hex'] ?? ''); if ($hex !== ''): ?>
                                            <span class="dt-color-dot" style="background:<?= htmlspecialchars($hex) ?>;"></span>
                                            <?php endif; ?>
                                            <span><?= htmlspecialchars((string)($val['name'] ?? '')) ?></span>
                                        </span>
                                        <?php endforeach; ?>
                                        <?php $extra = count($attr['values']) - count($shown); if ($extra > 0): ?>
                                        <span style="font-size:11px; color:#646970; margin-left:4px; align-self:center;">+<?= $extra ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td style="padding:12px 10px;">
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:3px 8px; border-radius:10px;"><?= count($attr['values']) ?> terms</span>
                                </td>
                                <td style="padding:12px 12px; text-align:right;">
                                    <div style="display:flex; gap:5px; justify-content:flex-end;">
                                        <a href="/admin/products/attributes/values.php?id=<?= (int)$attr['id'] ?>" class="dt-action-pill" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;" title="Configure Terms">
                                            <span>Configure Terms</span>
                                        </a>
                                        <button type="button" class="dt-action-pill" onclick="openEditAttrModal(<?= (int)$attr['id'] ?>, '<?= htmlspecialchars(addslashes($attr['name'])) ?>', '<?= htmlspecialchars(addslashes($attr['slug'])) ?>', '<?= htmlspecialchars(addslashes($attr['type'])) ?>')" style="background:#EFF6FF; border-color:#93C5FD; color:#1D4ED8;" title="Edit Attribute">
                                            <span>Edit</span>
                                        </button>
                                        <button type="button" class="dt-action-pill" onclick="deleteAttrRow(<?= (int)$attr['id'] ?>)" style="background:#FEF2F2; border-color:#FECACA; color:#DC2626;" title="Delete Attribute">
                                            <span>Del</span>
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
        <?php include_once __DIR__ . '/../../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- MODAL: ADD ATTRIBUTE -->
<div id="addAttributeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:520px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF;">Add New Textile Attribute</h3>
            <button type="button" onclick="closeAddAttributeModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Attribute Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="newAttrName" placeholder="e.g. Silk Purity Grade" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Display Type</label>
                <select id="newAttrType" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
                    <option value="Color Swatch / Hex">Color Swatch (Visual Palette)</option>
                    <option value="Text Badge / Pill">Text Pill / Button</option>
                    <option value="Size Specification">Size Specification</option>
                    <option value="Dropdown Menu">Dropdown Menu</option>
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Default Terms (Comma separated)</label>
                <input type="text" id="newAttrTerms" placeholder="e.g. 100% Silk Mark, Pure Katan, Art Silk" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAddAttributeModal()" style="height:32px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitNewAttribute()" style="height:32px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">+ Save Attribute</button>
        </div>
    </div>
</div>

<!-- MODAL: EDIT ATTRIBUTE -->
<div id="editAttributeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:480px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF;">Edit Attribute Details</h3>
            <button type="button" onclick="closeEditAttrModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <input type="hidden" id="editAttrId">
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Attribute Name</label>
                <input type="text" id="editAttrName" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Slug Identifier</label>
                <input type="text" id="editAttrSlug" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Display Type</label>
                <select id="editAttrType" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
                    <option value="Color Swatch / Hex">Color Swatch (Visual Palette)</option>
                    <option value="Text Badge / Pill">Text Pill / Button</option>
                    <option value="Size Specification">Size Specification</option>
                    <option value="Dropdown Menu">Dropdown Menu</option>
                </select>
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeEditAttrModal()" style="height:32px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="saveEditedAttribute()" style="height:32px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Update Changes</button>
        </div>
    </div>
</div>

<script>
function searchAttributes(q) {
    const term = (q || '').toLowerCase().trim();
    document.querySelectorAll('#attributesTableBody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
}

function openAddAttributeModal() {
    const m = document.getElementById('addAttributeModal');
    if (m) m.style.display = 'flex';
    document.getElementById('newAttrName')?.focus();
}

function closeAddAttributeModal() {
    const m = document.getElementById('addAttributeModal');
    if (m) m.style.display = 'none';
}

function submitNewAttribute() {
    const name = document.getElementById('newAttrName')?.value.trim();
    if (!name) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Please enter an attribute name');
        return;
    }
    const type = document.getElementById('newAttrType')?.value || 'Text Badge / Pill';
    const termsRaw = document.getElementById('newAttrTerms')?.value.trim();
    const slug = 'pa_' + name.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
    const termsArr = termsRaw ? termsRaw.split(',').map(s => s.trim()).filter(Boolean) : [];

    const params = new URLSearchParams();
    params.append('action', 'create');
    params.append('name', name);
    params.append('slug', slug);
    params.append('type', type);
    params.append('values', JSON.stringify(termsArr.map(t => ({ name: t, hex: null }))));

    fetch('/api/attributes.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Could not save'));
                return;
            }
            window.location.reload();
        })
        .catch(() => {
            if (typeof window.showToast === 'function') window.showToast('⚠️ Could not reach the server');
        });
}

function deleteAttrRow(id) {
    if (!confirm('Permanently delete this attribute and its saved terms?')) return;
    const params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);
    fetch('/api/attributes.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Delete failed'));
                return;
            }
            window.location.reload();
        })
        .catch(() => window.location.reload());
}

function openEditAttrModal(id, name, slug, type) {
    document.getElementById('editAttrId').value = id;
    document.getElementById('editAttrName').value = name;
    document.getElementById('editAttrSlug').value = slug;
    document.getElementById('editAttrType').value = type || 'Text Badge / Pill';
    document.getElementById('editAttributeModal').style.display = 'flex';
}

function closeEditAttrModal() {
    document.getElementById('editAttributeModal').style.display = 'none';
}

function saveEditedAttribute() {
    const id = document.getElementById('editAttrId').value;
    const name = document.getElementById('editAttrName').value.trim();
    const slug = document.getElementById('editAttrSlug').value.trim();
    const type = document.getElementById('editAttrType').value;
    if (!name) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Attribute name is required');
        return;
    }

    const params = new URLSearchParams();
    params.append('action', 'update');
    params.append('id', id);
    params.append('name', name);
    params.append('slug', slug);
    params.append('type', type);
    fetch('/api/attributes.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Update failed'));
                return;
            }
            window.location.reload();
        })
        .catch(() => window.location.reload());
}

function toggleSelectAllAttrs(master) {
    document.querySelectorAll('.attr-row-check').forEach(c => { c.checked = master.checked; });
}

function handleAttrBulkAction() {
    const action = document.getElementById('attrBulkActionSelect')?.value;
    if (!action) return;
    const ids = Array.from(document.querySelectorAll('.attr-row-check:checked')).map(c => c.value);
    if (ids.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one attribute');
        return;
    }
    if (action === 'delete') {
        if (!confirm(`Delete ${ids.length} attribute(s) permanently?`)) return;
        let done = 0;
        ids.forEach(id => {
            const params = new URLSearchParams();
            params.append('action', 'delete');
            params.append('id', id);
            fetch('/api/attributes.php', { method: 'POST', body: params, credentials: 'same-origin' })
                .then(() => { if (++done === ids.length) window.location.reload(); })
                .catch(() => { if (++done === ids.length) window.location.reload(); });
        });
    }
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>