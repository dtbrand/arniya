<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/feature-flags.php — Feature Flag Governance Centre
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm    = SystemManager::getInstance();
$csrf  = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$flags = $sm->getFeatureFlags();

// Group by category
$grouped = [];
foreach ($flags as $f) {
    $grouped[$f['category'] ?? 'general'][] = $f;
}

$active_nav    = 'system';
$active_subnav = 'feature-flags';
$page_title    = 'Feature Flags — DT Brand\'s';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/system/system.css?v=<?= time() ?>">
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="adm-page-head" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
                <div>
                    <h1 class="adm-page-title" style="display:flex;align-items:center;gap:8px;margin:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/></svg>
                        Feature Flags
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Toggle application features without deploying code. Changes take effect immediately.</p>
                </div>
                <div style="display:flex;gap:8px;align-items:center;">
                    <span class="sys-health-badge pass" style="font-size:.68rem;"><?= count(array_filter($flags, fn($f) => !empty($f['enabled']))) ?> Enabled</span>
                    <span class="sys-health-badge" style="font-size:.68rem;background:#F1F5F9;color:#64748B;"><?= count(array_filter($flags, fn($f) => empty($f['enabled']))) ?> Disabled</span>
                    <a href="/admin/system/" class="sys-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                        Suite
                    </a>
                </div>
            </div>

            <?php if (empty($flags)): ?>
            <div class="sys-card">
                <div class="sys-card-body" style="text-align:center;padding:40px;color:#94A3B8;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px;display:block;color:#CBD5E1;"><line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/></svg>
                    <div style="font-size:14px;font-weight:700;color:#64748B;margin-bottom:6px;">No Feature Flags Defined</div>
                    <div style="font-size:12.5px;">Run the migration to create the <code>feature_flags</code> table, then seed flags via the SystemManager.</div>
                </div>
            </div>
            <?php else: ?>

            <?php foreach ($grouped as $category => $catFlags): ?>
            <div class="sys-card" style="margin-bottom:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title" style="text-transform:capitalize;"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $category))) ?> Features</h3>
                    <span style="font-size:11px;color:#94A3B8;font-weight:600;"><?= count($catFlags) ?> flags</span>
                </div>
                <div>
                <?php foreach ($catFlags as $flag):
                    $enabled    = !empty($flag['enabled']);
                    $key        = htmlspecialchars($flag['key'] ?? $flag['flag_key'] ?? '');
                    $label      = htmlspecialchars($flag['label'] ?? $flag['flag_key'] ?? '');
                    $desc       = htmlspecialchars($flag['description'] ?? '');
                    $rollout    = $flag['rollout_percentage'] ?? 100;
                    $updatedAt  = $flag['updated_at'] ?? null;
                    $updatedBy  = $flag['updated_by_name'] ?? null;
                ?>
                <div class="sys-toggle-row" style="padding:14px 18px;">
                    <div class="sys-toggle-info">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="sys-toggle-name"><?= $label ?></div>
                            <code style="font-size:10.5px;color:#8A681F;background:#FAF5E8;border:1px solid #E6CA65;padding:1px 7px;border-radius:5px;"><?= $key ?></code>
                            <?php if ($rollout < 100): ?>
                            <span class="sys-health-badge warn" style="font-size:.6rem;"><?= $rollout ?>% rollout</span>
                            <?php endif; ?>
                        </div>
                        <div class="sys-toggle-desc" style="margin-top:2px;"><?= $desc ?></div>
                        <?php if ($updatedAt): ?>
                        <div style="font-size:10.5px;color:#CBD5E1;margin-top:3px;">
                            Last updated: <?= htmlspecialchars($updatedAt) ?><?= $updatedBy ? ' by ' . htmlspecialchars($updatedBy) : '' ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;margin-left:16px;">
                        <span style="font-size:11.5px;font-weight:700;color:<?= $enabled ? '#15803D' : '#94A3B8' ?>;"><?= $enabled ? 'ON' : 'OFF' ?></span>
                        <label class="sys-toggle">
                            <input type="checkbox" id="flag-<?= $key ?>"
                                <?= $enabled ? 'checked' : '' ?>
                                onchange="sysFlagToggle('<?= $key ?>', this.checked)">
                            <span class="sys-toggle-slider"></span>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <?php endif; ?>

            <!-- Info box -->
            <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:14px 18px;display:flex;gap:10px;align-items:flex-start;margin-top:4px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8" stroke-width="2.2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div style="font-size:12.5px;color:#1E40AF;">
                    Feature flags are stored in the <code>feature_flags</code> database table and cached in-memory. Toggling a flag fires an <strong>Audit Trail</strong> entry and takes effect within one request cycle.
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
</body>
</html>
