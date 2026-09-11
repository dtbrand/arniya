<?php
/**
 * admin/integrations/messaging.php — Messaging & Alerts Integration Console
 * Section 32 (Integrations Admin)
 * DT Brand's & Jai Hanuman Tex
 */

$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

// Database Connection
$pdo = null;
$dbFile = __DIR__ . '/../../config/database.php';
if (!is_file($dbFile)) {
    $dbFile = __DIR__ . '/../../includes/db.php';
}
if (is_file($dbFile)) {
    try {
        require_once $dbFile;
        if (isset($pdo) && $pdo instanceof PDO) {
            // using existing $pdo
        } elseif (isset($conn) && $conn instanceof PDO) {
            $pdo = $conn;
        } elseif (defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER') && defined('DB_PASS')) {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
    } catch (Exception $e) {
        $pdo = null;
    }
}

require_once __DIR__ . '/../../src/IntegrationManager.php';
use DT\Services\IntegrationManager;

$manager = IntegrationManager::getInstance($pdo);

$page_title = "Messaging & Notifications Integrations";
$active_nav = "integrations";
$active_subnav = "messaging";

$messagingGateways = $manager->getAll('messaging');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging Integrations — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/integrations/integrations.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:10px; margin:0;">
                        <span>Messaging &amp; Alerts Integrations</span>
                        <span class="adm-badge emerald" style="font-size:0.72rem; font-weight:800;">HIGH DELIVERABILITY</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Meta Cloud API WhatsApp Business, Hostinger SMTP SSL, and TRAI DLT-Approved SMS Gateways.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/integrations/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:36px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Integrations</span>
                    </a>
                </div>
            </div>

            <!-- Official WhatsApp Contact Banner -->
            <div style="background:#F0FDF4; border:1px solid #86EFAC; border-radius:12px; padding:18px 20px; margin-bottom:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
                <div>
                    <div style="font-size:0.95rem; font-weight:800; color:#166534; display:flex; align-items:center; gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>Official Master WhatsApp: +91 70463 63528 (Verified Business Account)</span>
                    </div>
                    <div style="font-size:0.8rem; color:#15803D; margin-top:4px;">
                        WABA Cloud API direct integration with automated order receipts, lot enquiry buttons, and dispatch tracking.
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="itg-status-badge active"><span class="itg-pulse-dot"></span> Meta Tier 2 Verified</span>
                </div>
            </div>

            <!-- Gateways List -->
            <div class="itg-cards-grid">
                <?php foreach ($messagingGateways as $item): ?>
                    <?php
                        $slug = htmlspecialchars($item['slug']);
                        $name = htmlspecialchars($item['name']);
                        $desc = htmlspecialchars($item['description']);
                        $isEnabled = !empty($item['is_enabled']);
                        $latency = $item['last_ping_latency_ms'] ?? 45;
                        $lastReq = $item['last_request_at'] ? date('M j, H:i', strtotime($item['last_request_at'])) : 'Never';
                        $reqStatus = htmlspecialchars($item['last_request_status'] ?? '200 OK');
                        $hasWebhook = !empty($item['webhook_url']);
                    ?>
                    <div class="itg-card" id="card-<?php echo $slug; ?>">
                        <div>
                            <div class="itg-card-header">
                                <div class="itg-card-brand">
                                    <div class="itg-avatar">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="itg-card-cat">COMMUNICATION CLOUD</div>
                                        <div class="itg-card-title"><?php echo $name; ?></div>
                                    </div>
                                </div>
                                <div id="badge-<?php echo $slug; ?>" class="itg-status-badge <?php echo $isEnabled ? 'active' : 'inactive'; ?>">
                                    <?php if ($isEnabled): ?>
                                        <span class="itg-pulse-dot"></span> Active
                                    <?php else: ?>
                                        Inactive
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="itg-card-desc"><?php echo $desc; ?></div>

                            <div class="itg-metrics-row">
                                <div class="itg-metric-item">
                                    <span class="itg-metric-label">Latency</span>
                                    <span class="itg-metric-val latency" id="latency-<?php echo $slug; ?>"><?php echo $latency; ?> ms</span>
                                </div>
                                <div class="itg-metric-item">
                                    <span class="itg-metric-label">Last Dispatch</span>
                                    <span class="itg-metric-val"><?php echo $lastReq; ?></span>
                                </div>
                                <div class="itg-metric-item">
                                    <span class="itg-metric-label">Status</span>
                                    <span class="itg-metric-val" style="color:#15803D;">Ready</span>
                                </div>
                            </div>
                        </div>

                        <div class="itg-card-actions">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <label class="itg-switch">
                                    <input type="checkbox" <?php echo $isEnabled ? 'checked' : ''; ?> onchange="toggleIntegration('<?php echo $slug; ?>', this.checked)">
                                    <span class="itg-slider"></span>
                                </label>
                                <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:11px; padding:0 12px;" onclick="testIntegrationConnection('<?php echo $slug; ?>', this)">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                    <span>Test Ping</span>
                                </button>
                            </div>

                            <div style="display:flex; align-items:center; gap:6px;">
                                <button type="button" class="dt-btn dt-btn-pale" style="height:32px; font-size:11px; padding:0 10px; display:inline-flex; align-items:center; gap:5px;" onclick="openDiagnosticsModal('<?php echo $slug; ?>', '<?php echo addslashes($name); ?>')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                    <span>Diagnostics</span>
                                </button>
                                <button type="button" class="dt-btn dt-btn-dark" style="height:32px; font-size:11px; padding:0 10px; display:inline-flex; align-items:center; gap:5px;" onclick="openConfigModal('<?php echo $slug; ?>', '<?php echo addslashes($name); ?>')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <span>Masked Keys</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Diagnostics Modal -->
            <div id="itgDiagnosticsModal" class="itg-modal-backdrop">
                <div class="itg-modal-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; border-bottom:1px solid #E2E8F0; padding-bottom:12px;">
                        <h3 id="itgDiagTitle" style="margin:0; font-size:1.1rem; font-weight:800;">Safe Diagnostics</h3>
                        <button type="button" onclick="closeDiagnosticsModal()" style="background:none; border:none; cursor:pointer; font-size:1.3rem;">&times;</button>
                    </div>
                    <div id="itgDiagResults"></div>
                    <div style="margin-top:20px; text-align:right;">
                        <button type="button" class="dt-btn dt-btn-dark" style="height:34px;" onclick="closeDiagnosticsModal()">Close</button>
                    </div>
                </div>
            </div>

            <!-- Config Modal -->
            <div id="itgConfigModal" class="itg-modal-backdrop">
                <div class="itg-modal-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; border-bottom:1px solid #E2E8F0; padding-bottom:12px;">
                        <h3 id="itgConfigTitle" style="margin:0; font-size:1.1rem; font-weight:800;">Configure Credentials</h3>
                        <button type="button" onclick="closeConfigModal()" style="background:none; border:none; cursor:pointer; font-size:1.3rem;">&times;</button>
                    </div>
                    <form id="itgConfigForm" onsubmit="saveIntegrationConfig(event)">
                        <input type="hidden" name="slug" id="itgConfigSlug" value="">
                        <div id="itgConfigFields"></div>
                        <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.75rem; color:#64748B;">Masked secrets are protected.</span>
                            <div style="display:flex; gap:8px;">
                                <button type="button" class="dt-btn dt-btn-pale" style="height:34px;" onclick="closeConfigModal()">Cancel</button>
                                <button type="submit" class="dt-btn dt-btn-gold" style="height:34px;">Save Credentials</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/integrations/integrations.js?v=<?php echo time(); ?>"></script>
</body>
</html>
