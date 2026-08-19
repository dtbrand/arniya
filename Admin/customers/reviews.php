<?php
/**
 * reviews.php — ARNIYA Admin Customers Module
 * DT Brand's & Jai Hanuman Tex
 */

$page_title = 'Customers — Reviews';
$active_nav = 'customers';
$extra_css = ['/Admin/customers/customers.css'];
$extra_js = ['/Admin/customers/customers.js'];

include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="adm-main">
    <?php include_once __DIR__ . '/../includes/topbar.php'; ?>

    <main class="adm-content-container">
        <section class="adm-dash-header">
            <div class="adm-dash-title-group">
                <?php include_once __DIR__ . '/../includes/breadcrumbs.php'; ?>
                <h1 class="adm-dash-title">
                    <span>Customers — Reviews</span>
                    <span class="adm-badge gold">CUSTOMERS MODULE</span>
                </h1>
                <p class="adm-dash-subtitle">Manage and configure customers data for ARNIYA e-commerce platform.</p>
            </div>
            <div class="adm-dash-controls">
                <a href="/Admin/dashboard/" class="adm-btn-secondary">← Back to Dashboard</a>
                <button type="button" class="adm-btn-primary" onclick="window.showToast('Action saved successfully!', 'emerald')">Save Changes</button>
            </div>
        </section>

        <section class="adm-card">
            <div class="adm-card-head">
                <div class="adm-card-title-wrap">
                    <h2 class="adm-card-title">📋 Customers — Reviews Overview</h2>
                    <span class="adm-card-subtitle">Ready for PHP + MySQL database integration</span>
                </div>
                <button type="button" class="adm-tbl-action-btn" onclick="window.openAdmModal('admExportModal')">Export Data</button>
            </div>
            <div style="padding:24px; text-align:center; background:#FAF8F4; border-radius:8px; border:1px dashed var(--adm-border-soft);">
                <div style="font-size:2rem; margin-bottom:8px;">⚙️</div>
                <h3 style="font-size:1.1rem; font-weight:800; color:var(--adm-text-main);">Customers — Reviews Module Ready</h3>
                <p style="font-size:0.80rem; color:var(--adm-text-muted); max-width:500px; margin:6px auto 16px;">
                    This modular view is fully wired into the ARNIYA desktop architecture, shared assets, navigation, and theme system.
                </p>
                <div style="display:flex; justify-content:center; gap:10px;">
                    <a href="/Admin/customers/" class="adm-btn-secondary">View Module Index</a>
                    <a href="/Admin/dashboard/" class="adm-btn-primary">Go to Dashboard</a>
                </div>
            </div>
        </section>
    </main>

<?php
include_once __DIR__ . '/../includes/footer.php';
?>
