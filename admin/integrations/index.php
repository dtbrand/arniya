<?php
/**
 * admin/integrations/index.php — Master Integrations & API Hub
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

$page_title = "Integrations & API Hub";
$active_nav = "integrations";
$active_subnav = "";

// Selected category filter
$catFilter = $_GET['cat'] ?? 'all';
$integrations = $manager->getAll($catFilter);
$stats = $manager->getStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integrations &amp; API Hub — DT Brand's Admin</title>
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
            
            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:10px; margin:0;">
                        <span>Integrations &amp; Gateway Hub</span>
                        <span class="adm-badge gold" style="font-size:0.72rem; font-weight:800;">SECTION 32 MASTER</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Real-time status, connection diagnostics, safe credentials, and webhook management for all external APIs.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/integrations/webhooks.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:36px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span>Webhooks Central</span>
                    </a>
                    <a href="/admin/integrations/diagnostics.php" class="dt-btn dt-btn-dark" style="text-decoration:none; height:36px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                        <span>Safe Diagnostics Lab</span>
                    </a>
                    <a href="/admin/integrations/logs.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:36px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        <span>Request Logs</span>
                    </a>
                </div>
            </div>

            <!-- KPI Ribbon -->
            <div class="itg-kpi-grid">
                <div class="itg-kpi-card">
                    <div>
                        <div class="itg-kpi-val"><?php echo $stats['active_integrations']; ?> / <?php echo $stats['total_integrations']; ?></div>
                        <div class="itg-kpi-label">Active Gateways</div>
                    </div>
                    <div class="itg-kpi-icon-wrap emerald">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                </div>

                <div class="itg-kpi-card">
                    <div>
                        <div class="itg-kpi-val"><?php echo $stats['connected_gateways']; ?></div>
                        <div class="itg-kpi-label">Healthy (Score &gt; 90)</div>
                    </div>
                    <div class="itg-kpi-icon-wrap gold">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                </div>

                <div class="itg-kpi-card">
                    <div>
                        <div class="itg-kpi-val"><?php echo $stats['webhook_health_score']; ?>%</div>
                        <div class="itg-kpi-label">Webhook Health</div>
                    </div>
                    <div class="itg-kpi-icon-wrap blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>
                </div>

                <div class="itg-kpi-card">
                    <div>
                        <div class="itg-kpi-val"><?php echo $stats['average_latency_ms']; ?> <span style="font-size:0.9rem; font-weight:600; color:#64748B;">ms</span></div>
                        <div class="itg-kpi-label">Avg Cloud Latency</div>
                    </div>
                    <div class="itg-kpi-icon-wrap amber">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Category Filter Tabs -->
            <div class="itg-tabs-row">
                <div class="itg-filter-pills">
                    <a href="?cat=all" class="itg-pill <?php echo $catFilter === 'all' ? 'active' : ''; ?>">
                        <span>All Integrations</span>
                        <span style="opacity:0.8; font-size:0.75rem;">(<?php echo $stats['total_integrations']; ?>)</span>
                    </a>
                    <a href="?cat=payment" class="itg-pill <?php echo $catFilter === 'payment' ? 'active' : ''; ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>Payment</span>
                        <span style="opacity:0.8; font-size:0.75rem;">(<?php echo $stats['categories']['payment']; ?>)</span>
                    </a>
                    <a href="?cat=shipping" class="itg-pill <?php echo $catFilter === 'shipping' ? 'active' : ''; ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Shipping &amp; Logistics</span>
                        <span style="opacity:0.8; font-size:0.75rem;">(<?php echo $stats['categories']['shipping']; ?>)</span>
                    </a>
                    <a href="?cat=messaging" class="itg-pill <?php echo $catFilter === 'messaging' ? 'active' : ''; ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>Messaging &amp; Alerts</span>
                        <span style="opacity:0.8; font-size:0.75rem;">(<?php echo $stats['categories']['messaging']; ?>)</span>
                    </a>
                </div>

                <div style="font-size:0.8rem; color:#64748B; display:flex; align-items:center; gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Zero Secret Exposure: All tokens strictly masked (••••••••)</span>
                </div>
            </div>

            <!-- Integrations Grid -->
            <div class="itg-cards-grid">
                <?php foreach ($integrations as $item): ?>
                    <?php
                        $slug = htmlspecialchars($item['slug']);
                        $name = htmlspecialchars($item['name']);
                        $cat = htmlspecialchars($item['category']);
                        $desc = htmlspecialchars($item['description']);
                        $isEnabled = !empty($item['is_enabled']);
                        $status = $item['status'] ?? 'active';
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
                                        <?php if ($cat === 'payment'): ?>
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                        <?php elseif ($cat === 'shipping'): ?>
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                        <?php else: ?>
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="itg-card-cat"><?php echo strtoupper($cat); ?></div>
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
                                    <span class="itg-metric-label">Last Probe</span>
                                    <span class="itg-metric-val"><?php echo $lastReq; ?></span>
                                </div>
                                <div class="itg-metric-item">
                                    <span class="itg-metric-label">HTTP Status</span>
                                    <span class="itg-metric-val" style="color:#15803D;"><?php echo $reqStatus; ?></span>
                                </div>
                                <div class="itg-metric-item">
                                    <span class="itg-metric-label">Webhook</span>
                                    <span class="itg-metric-val" style="color:<?php echo $hasWebhook ? '#15803D' : '#64748B'; ?>;">
                                        <?php echo $hasWebhook ? 'Active' : 'N/A'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="itg-card-actions">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <label class="itg-switch" title="Toggle Enable/Disable">
                                    <input type="checkbox" <?php echo $isEnabled ? 'checked' : ''; ?> onchange="toggleIntegration('<?php echo $slug; ?>', this.checked)">
                                    <span class="itg-slider"></span>
                                </label>
                                <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:11px; padding:0 12px;" onclick="testIntegrationConnection('<?php echo $slug; ?>', this)">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                    <span>Ping</span>
                                </button>
                            </div>

                            <div style="display:flex; align-items:center; gap:6px;">
                                <button type="button" class="dt-btn dt-btn-pale" style="height:32px; font-size:11px; padding:0 10px;" onclick="openDiagnosticsModal('<?php echo $slug; ?>', '<?php echo addslashes($name); ?>')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                    <span>Diagnostics</span>
                                </button>
                                <button type="button" class="dt-btn dt-btn-dark" style="height:32px; font-size:11px; padding:0 10px;" onclick="openConfigModal('<?php echo $slug; ?>', '<?php echo addslashes($name); ?>')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <span>Keys</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Safe Diagnostics Modal -->
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

            <!-- Configure Credentials Modal -->
            <div id="itgConfigModal" class="itg-modal-backdrop">
                <div class="itg-modal-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; border-bottom:1px solid #E2E8F0; padding-bottom:12px;">
                        <h3 id="itgConfigTitle" style="margin:0; font-size:1.1rem; font-weight:800; color:#111827;">Configure Integration</h3>
                        <button type="button" onclick="closeConfigModal()" style="background:none; border:none; cursor:pointer; color:#64748B; font-size:1.3rem;">&times;</button>
                    </div>
                    <form id="itgConfigForm" onsubmit="saveIntegrationConfig(event)">
                        <input type="hidden" name="slug" id="itgConfigSlug" value="">
                        <div id="itgConfigFields"></div>
                        <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.75rem; color:#64748B;">Unchanged masked secrets will remain intact.</span>
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
