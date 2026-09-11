<?php
/**
 * admin/integrations/logs.php — Integration Request Ledger
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

$page_title = "Integration Request Ledger";
$active_nav = "integrations";
$active_subnav = "logs";

$filterSlug = $_GET['slug'] ?? 'all';
$filterStatus = $_GET['status'] ?? 'all';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;

$logs = $manager->getLogs($filterSlug, $filterStatus, $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integration Request Ledger — DT Brand's Admin</title>
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
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Integration Request Ledger</span>
                        <span class="adm-badge gold" style="font-size:0.72rem; font-weight:800;">AUDIT TRAIL</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Real-time audit log of external API dispatches, carrier tracking syncs, and webhook payloads.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/integrations/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:36px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Integrations</span>
                    </a>
                </div>
            </div>

            <!-- Filters Toolbar -->
            <form method="GET" style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:12px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:center; flex-wrap:wrap; gap:14px;">
                <div>
                    <label style="display:flex; align-items:center; gap:5px; font-size:0.72rem; font-weight:700; color:#475569; margin-bottom:4px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>GATEWAY</span>
                    </label>
                    <select name="slug" class="dt-input-field" style="height:36px; font-size:0.82rem; padding:0 12px;">
                        <option value="all" <?php echo $filterSlug === 'all' ? 'selected' : ''; ?>>All Gateways</option>
                        <option value="razorpay" <?php echo $filterSlug === 'razorpay' ? 'selected' : ''; ?>>Razorpay</option>
                        <option value="cashfree" <?php echo $filterSlug === 'cashfree' ? 'selected' : ''; ?>>Cashfree</option>
                        <option value="delhivery" <?php echo $filterSlug === 'delhivery' ? 'selected' : ''; ?>>Delhivery</option>
                        <option value="bluedart" <?php echo $filterSlug === 'bluedart' ? 'selected' : ''; ?>>BlueDart</option>
                        <option value="tci" <?php echo $filterSlug === 'tci' ? 'selected' : ''; ?>>TCI Freight</option>
                        <option value="whatsapp" <?php echo $filterSlug === 'whatsapp' ? 'selected' : ''; ?>>WhatsApp</option>
                        <option value="email" <?php echo $filterSlug === 'email' ? 'selected' : ''; ?>>Email SMTP</option>
                        <option value="sms" <?php echo $filterSlug === 'sms' ? 'selected' : ''; ?>>Fast2SMS</option>
                    </select>
                </div>

                <div>
                    <label style="display:flex; align-items:center; gap:5px; font-size:0.72rem; font-weight:700; color:#475569; margin-bottom:4px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>STATUS</span>
                    </label>
                    <select name="status" class="dt-input-field" style="height:36px; font-size:0.82rem; padding:0 12px;">
                        <option value="all" <?php echo $filterStatus === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                        <option value="success" <?php echo $filterStatus === 'success' ? 'selected' : ''; ?>>Success (200 OK)</option>
                        <option value="failed" <?php echo $filterStatus === 'failed' ? 'selected' : ''; ?>>Failed</option>
                        <option value="warning" <?php echo $filterStatus === 'warning' ? 'selected' : ''; ?>>Warning</option>
                    </select>
                </div>

                <div>
                    <label style="display:flex; align-items:center; gap:5px; font-size:0.72rem; font-weight:700; color:#475569; margin-bottom:4px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line></svg>
                        <span>LIMIT</span>
                    </label>
                    <select name="limit" class="dt-input-field" style="height:36px; font-size:0.82rem; padding:0 12px;">
                        <option value="25" <?php echo $limit === 25 ? 'selected' : ''; ?>>25 Records</option>
                        <option value="50" <?php echo $limit === 50 ? 'selected' : ''; ?>>50 Records</option>
                        <option value="100" <?php echo $limit === 100 ? 'selected' : ''; ?>>100 Records</option>
                    </select>
                </div>

                <div style="margin-top:20px;">
                    <button type="submit" class="dt-btn dt-btn-gold" style="height:36px; font-size:12px; font-weight:700; padding:0 16px; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        <span>Filter Logs</span>
                    </button>
                </div>
            </form>

            <!-- Logs Table -->
            <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:14px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div class="adm-table-responsive">
                    <table class="adm-table" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#F1F5F9; text-align:left; font-size:0.75rem; color:#475569; text-transform:uppercase;">
                                <th style="padding:12px 18px;">ID</th>
                                <th style="padding:12px 18px;">Timestamp</th>
                                <th style="padding:12px 18px;">Gateway</th>
                                <th style="padding:12px 18px;">Action</th>
                                <th style="padding:12px 18px;">Endpoint</th>
                                <th style="padding:12px 18px;">Latency</th>
                                <th style="padding:12px 18px;">Status</th>
                                <th style="padding:12px 18px;">Payload (Masked)</th>
                                <th style="padding:12px 18px;">Origin IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                                <tr>
                                    <td colspan="9" style="text-align:center; padding:32px; color:#64748B;">No integration logs matching filter.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr style="border-bottom:1px solid #F1F5F9; font-size:0.82rem;">
                                        <td style="padding:12px 18px; color:#64748B; font-weight:700;">#<?php echo $log['id']; ?></td>
                                        <td style="padding:12px 18px; color:#475569; font-size:0.75rem;">
                                            <?php echo date('H:i:s, d M', strtotime($log['created_at'])); ?>
                                        </td>
                                        <td style="padding:12px 18px; font-weight:800; color:#111827; text-transform:uppercase;">
                                            <?php echo htmlspecialchars($log['integration_slug']); ?>
                                        </td>
                                        <td style="padding:12px 18px; font-weight:600; color:#0F172A;">
                                            <?php echo htmlspecialchars($log['action']); ?>
                                        </td>
                                        <td style="padding:12px 18px; font-family:monospace; font-size:0.75rem; color:#1D4ED8; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            <?php echo htmlspecialchars($log['endpoint'] ?? 'Cloud API'); ?>
                                        </td>
                                        <td style="padding:12px 18px; font-weight:700; color:#15803D;">
                                            <?php echo (int)($log['latency_ms'] ?? 45); ?> ms
                                        </td>
                                        <td style="padding:12px 18px;">
                                            <span style="background:<?php echo ($log['status'] ?? '') === 'success' ? '#DCFCE7' : '#FEF2F2'; ?>; color:<?php echo ($log['status'] ?? '') === 'success' ? '#15803D' : '#DC2626'; ?>; padding:2px 8px; border-radius:4px; font-size:0.72rem; font-weight:800;">
                                                <?php echo (int)$log['http_status']; ?> <?php echo strtoupper($log['status']); ?>
                                            </span>
                                        </td>
                                        <td style="padding:12px 18px; font-family:monospace; font-size:0.72rem; color:#64748B; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            <?php echo htmlspecialchars($log['payload_summary'] ?? 'N/A'); ?>
                                        </td>
                                        <td style="padding:12px 18px; color:#64748B; font-size:0.75rem;">
                                            <?php echo htmlspecialchars($log['ip_address'] ?? '127.0.0.1'); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/integrations/integrations.js?v=<?php echo time(); ?>"></script>
</body>
</html>
