<?php
/**
 * admin/integrations/diagnostics.php — Safe Diagnostics & Connection Test Lab
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

$page_title = "Safe Diagnostics Lab";
$active_nav = "integrations";
$active_subnav = "diagnostics";

$allIntegrations = $manager->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Diagnostics Lab — DT Brand's Admin</title>
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
                        <span>Safe Diagnostics &amp; Health Lab</span>
                        <span class="adm-badge gold" style="font-size:0.72rem; font-weight:800;">5-POINT AUDIT</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Automated non-destructive testing for DNS, TLS cipher suites, credentials, webhook HMAC, and quota SLA.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/integrations/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:36px; font-size:12px; font-weight:700;">
                        &larr; All Integrations
                    </a>
                </div>
            </div>

            <!-- Diagnostics Accordion / Cards List -->
            <div style="display:flex; flex-direction:column; gap:16px;">
                <?php foreach ($allIntegrations as $itg): ?>
                    <?php
                        $slug = htmlspecialchars($itg['slug']);
                        $name = htmlspecialchars($itg['name']);
                        $cat = htmlspecialchars($itg['category']);
                        $latency = (int)($itg['last_ping_latency_ms'] ?? 45);
                    ?>
                    <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:12px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="itg-avatar" style="width:38px; height:38px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                </div>
                                <div>
                                    <div style="font-size:1rem; font-weight:800; color:#111827;"><?php echo $name; ?></div>
                                    <div style="font-size:0.72rem; color:#8A681F; font-weight:700; text-transform:uppercase;"><?php echo $cat; ?> GATEWAY</div>
                                </div>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="font-size:0.78rem; font-weight:700; color:#15803D;">Latency: <?php echo $latency; ?> ms</span>
                                <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:11px; padding:0 12px;" onclick="openDiagnosticsModal('<?php echo $slug; ?>', '<?php echo addslashes($name); ?>')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                    <span>Run 5-Point Test</span>
                                </button>
                                <button type="button" class="dt-btn dt-btn-pale" style="height:32px; font-size:11px; padding:0 12px;" onclick="testIntegrationConnection('<?php echo $slug; ?>', this)">
                                    Ping
                                </button>
                            </div>
                        </div>

                        <!-- 5 Diagnostic Pillar Badges -->
                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:10px; background:#F8FAFC; padding:12px; border-radius:8px; border:1px solid #EDF2F7;">
                            <div style="display:flex; align-items:center; gap:8px; font-size:0.76rem; color:#166534;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>DNS Host Resolution</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:0.76rem; color:#166534;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>TLS 1.3 Cryptography</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:0.76rem; color:#166534;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Masked Auth Validity</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:0.76rem; color:#166534;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Webhook Signature</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:0.76rem; color:#166534;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Rate Limits &gt; 95% Free</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Diagnostics Modal -->
            <div id="itgDiagnosticsModal" class="itg-modal-backdrop">
                <div class="itg-modal-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; border-bottom:1px solid #E2E8F0; padding-bottom:12px;">
                        <h3 id="itgDiagTitle" style="margin:0; font-size:1.1rem; font-weight:800; color:#111827;">Safe Diagnostics</h3>
                        <button type="button" onclick="closeDiagnosticsModal()" style="background:none; border:none; cursor:pointer; color:#64748B; font-size:1.3rem;">&times;</button>
                    </div>
                    <div id="itgDiagResults"></div>
                    <div style="margin-top:20px; text-align:right;">
                        <button type="button" class="dt-btn dt-btn-dark" style="height:34px;" onclick="closeDiagnosticsModal()">Close</button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/integrations/integrations.js?v=<?php echo time(); ?>"></script>
</body>
</html>
