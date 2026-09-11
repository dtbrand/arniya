<?php
/**
 * index.php — Master Enterprise Audit Log Console
 * DT Brand's & Jai Hanuman Tex
 * Section 35: Central Enterprise Audit Log Admin
 */

// Dual relative adminguard check
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) {
    require_once $__dtg;
}

require_once __DIR__ . '/../../src/AuditManager.php';

use DTBrand\AuditManager;

$auditManager = AuditManager::getInstance();

$page_title = "Enterprise Audit Logs";
$active_nav = "audit";
$current_subnav = "index";

// Query filters
$search         = trim((string)($_GET['search'] ?? ''));
$entityType     = trim((string)($_GET['entity_type'] ?? ''));
$actionFilter   = trim((string)($_GET['action_filter'] ?? ''));
$status         = trim((string)($_GET['status'] ?? ''));
$actor          = trim((string)($_GET['actor'] ?? ''));
$correlationId  = trim((string)($_GET['correlation_id'] ?? ''));
$dateFrom       = trim((string)($_GET['date_from'] ?? ''));
$dateTo         = trim((string)($_GET['date_to'] ?? ''));
$page           = max(1, (int)($_GET['page'] ?? 1));
$limit          = 25;

$filters = [
    'search'         => $search,
    'entity_type'    => $entityType,
    'action'         => $actionFilter,
    'status'         => $status,
    'actor'          => $actor,
    'correlation_id' => $correlationId,
    'date_from'      => $dateFrom,
    'date_to'        => $dateTo,
    'page'           => $page,
    'limit'          => $limit,
];

$result = $auditManager->getLogs($filters);
$logs   = $result['items'];
$total  = $result['total'];
$pages  = $result['pages'];

$stats = $auditManager->getAuditStats();

// Helper for query strings
function buildAuditQuery(array $overrides = []): string
{
    $params = array_merge($_GET, $overrides);
    return '?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Audit Logs - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/audit/audit.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <!-- Page Header -->
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Enterprise Audit Log Console</span>
                        <span class="adm-badge gold"><?php echo number_format($total); ?> Total Events</span>
                    </h1>
                    <p class="adm-page-subtitle">Centralized administrative activity trail, causality chains, and forensic state diff tracking.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/api/audit.php?action=export<?php echo !empty($_SERVER['QUERY_STRING']) ? '&' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''; ?>" class="dt-btn-pale">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        <span>Export CSV</span>
                    </a>
                </div>
            </div>

            <!-- KPI Ribbon -->
            <div class="audit-kpi-ribbon">
                <div class="audit-kpi-card">
                    <div class="audit-kpi-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                        24h Events
                    </div>
                    <div class="audit-kpi-value"><?php echo number_format((int)($stats['events_24h'] ?? 0)); ?></div>
                    <div class="audit-kpi-sub">Total platform changes today</div>
                </div>

                <div class="audit-kpi-card">
                    <div class="audit-kpi-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        Warnings / Issues
                    </div>
                    <div class="audit-kpi-value" style="color: #B45309;"><?php echo number_format((int)($stats['warnings_24h'] ?? 0)); ?></div>
                    <div class="audit-kpi-sub">Failed logins &amp; security warnings</div>
                </div>

                <div class="audit-kpi-card">
                    <div class="audit-kpi-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path></svg>
                        Active Actors
                    </div>
                    <div class="audit-kpi-value"><?php echo number_format((int)($stats['unique_actors_24h'] ?? 0)); ?></div>
                    <div class="audit-kpi-sub">Staff members making changes</div>
                </div>

                <div class="audit-kpi-card">
                    <div class="audit-kpi-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                        Correlation Traces
                    </div>
                    <div class="audit-kpi-value"><?php echo number_format((int)($stats['active_traces_24h'] ?? 0)); ?></div>
                    <div class="audit-kpi-sub">Chained cross-service requests</div>
                </div>
            </div>

            <!-- Filter Toolbar -->
            <div class="audit-filter-bar">
                <form method="GET" action="/admin/audit/index.php" class="audit-filter-grid">
                    <div class="audit-form-group">
                        <label for="search">Keyword Search</label>
                        <input type="text" name="search" id="search" class="audit-input dt-input-field" placeholder="Search actor, entity ID, description, or action..." value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="audit-form-group">
                        <label for="entity_type">Entity Category</label>
                        <select name="entity_type" id="entity_type" class="audit-input dt-input-field">
                            <option value="">All Categories (15)</option>
                            <?php foreach (AuditManager::ALL_CATEGORIES as $cat): ?>
                                <option value="<?php echo $cat; ?>" <?php echo $entityType === $cat ? 'selected' : ''; ?>>
                                    <?php echo ucfirst(str_replace('_', ' ', $cat)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="audit-form-group">
                        <label for="status">Event Status</label>
                        <select name="status" id="status" class="audit-input dt-input-field">
                            <option value="">All Statuses</option>
                            <option value="success" <?php echo $status === 'success' ? 'selected' : ''; ?>>Success</option>
                            <option value="warning" <?php echo $status === 'warning' ? 'selected' : ''; ?>>Warning</option>
                            <option value="failure" <?php echo $status === 'failure' ? 'selected' : ''; ?>>Failure</option>
                        </select>
                    </div>

                    <div class="audit-form-group">
                        <label for="date_from">Date From</label>
                        <input type="date" name="date_from" id="date_from" class="audit-input dt-input-field" value="<?php echo htmlspecialchars($dateFrom, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="audit-form-group">
                        <label for="date_to">Date To</label>
                        <input type="date" name="date_to" id="date_to" class="audit-input dt-input-field" value="<?php echo htmlspecialchars($dateTo, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <button type="submit" class="dt-btn-gold">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Filter</span>
                    </button>

                    <a href="/admin/audit/index.php" class="dt-btn-pale" title="Reset Filters">Reset</a>
                </form>
            </div>

            <!-- Audit Log Feed Table Card -->
            <div class="audit-table-card">
                <div class="audit-table-header">
                    <h3 class="audit-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Activity Ledger Feed</span>
                    </h3>
                    <div style="font-size: 0.78rem; font-weight: 600; color: #64748B;">
                        Showing page <?php echo $page; ?> of <?php echo max(1, $pages); ?>
                    </div>
                </div>

                <div class="audit-table-responsive">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Actor / Role</th>
                                <th>Category</th>
                                <th>Action</th>
                                <th>Entity &amp; ID</th>
                                <th>Description / Details</th>
                                <th>Correlation ID</th>
                                <th>State Diff</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                                <tr>
                                    <td colspan="9" style="text-align:center; padding: 40px; color: #64748B;">
                                        No audit log events found matching the specified filter criteria.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td style="white-space:nowrap; font-size:0.75rem; color:#64748B;">
                                            <?php echo htmlspecialchars((string)($log['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: #111827;">
                                                <?php echo htmlspecialchars((string)($log['user_name'] ?? 'system'), ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                            <div style="font-size: 0.7rem; color: #8A681F; font-weight: 600;">
                                                <?php echo htmlspecialchars((string)($log['actor_role'] ?? 'admin'), ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="cat-badge <?php echo htmlspecialchars((string)($log['entity_type'] ?? 'system'), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', (string)($log['entity_type'] ?? 'system'))), ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <code style="font-weight: 700; color: #0F172A;"><?php echo htmlspecialchars((string)($log['action'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></code>
                                        </td>
                                        <td>
                                            <strong style="color:#1E293B;"><?php echo htmlspecialchars((string)($log['entity_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
                                        </td>
                                        <td style="max-width: 280px;">
                                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.78rem;" title="<?php echo htmlspecialchars((string)($log['details'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars((string)($log['details'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($log['correlation_id'])): ?>
                                                <span class="corr-pill" onclick="window.copyCorrelationId(event, '<?php echo htmlspecialchars((string)$log['correlation_id'], ENT_QUOTES, 'UTF-8'); ?>');" title="Click to copy correlation ID">
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                                    <?php echo htmlspecialchars(substr((string)$log['correlation_id'], 0, 14), ENT_QUOTES, 'UTF-8'); ?>...
                                                </span>
                                            <?php else: ?>
                                                <span style="color:#94A3B8;">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="dt-btn-pale" style="height:28px; padding:0 8px; font-size:0.72rem;" onclick="window.inspectAuditDiff(<?php echo (int)$log['id']; ?>)">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                                <span>Diff</span>
                                            </button>
                                        </td>
                                        <td>
                                            <span class="status-pill <?php echo htmlspecialchars((string)($log['status'] ?? 'success'), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars(ucfirst((string)($log['status'] ?? 'success')), ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pages > 1): ?>
                    <div style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #E2E8F0; background: #FAFBFD;">
                        <div style="font-size: 0.8rem; color: #64748B;">
                            Showing <strong><?php echo count($logs); ?></strong> of <strong><?php echo number_format($total); ?></strong> events
                        </div>
                        <div style="display: flex; gap: 6px;">
                            <?php if ($page > 1): ?>
                                <a href="<?php echo buildAuditQuery(['page' => $page - 1]); ?>" class="dt-btn-pale" style="height:32px; padding:0 10px;">&laquo; Prev</a>
                            <?php endif; ?>

                            <?php for ($p = max(1, $page - 2); $p <= min($pages, $page + 2); $p++): ?>
                                <a href="<?php echo buildAuditQuery(['page' => $p]); ?>" class="<?php echo $p === $page ? 'dt-btn-gold' : 'dt-btn-pale'; ?>" style="height:32px; padding:0 10px;">
                                    <?php echo $p; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $pages): ?>
                                <a href="<?php echo buildAuditQuery(['page' => $page + 1]); ?>" class="dt-btn-pale" style="height:32px; padding:0 10px;">Next &raquo;</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </main>
    </div>
</div>

<!-- JSON Diff Inspector Modal -->
<div class="audit-modal-backdrop" id="auditDiffModal" onclick="if(event.target===this) window.closeAuditModal();">
    <div class="audit-modal-window">
        <div class="audit-modal-header">
            <div>
                <h3 class="audit-modal-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    <span>Forensic State Diff Inspector</span>
                </h3>
                <div id="auditDiffModalSub" style="font-size: 0.76rem; color: #64748B; margin-top: 2px;">Comparing before &amp; after states</div>
            </div>
            <button type="button" class="dt-btn-pale" style="height:30px; padding:0 8px;" onclick="window.closeAuditModal();">&times;</button>
        </div>
        <div class="audit-modal-body" id="auditDiffModalBody">
            <!-- Loaded dynamically via AJAX -->
        </div>
        <div class="audit-modal-footer">
            <button type="button" class="dt-btn-pale" onclick="window.closeAuditModal();">Close</button>
        </div>
    </div>
</div>

<!-- Correlation Trace Modal -->
<div class="audit-modal-backdrop" id="auditTraceModal" onclick="if(event.target===this) window.closeAuditModal();">
    <div class="audit-modal-window" style="max-width: 680px;">
        <div class="audit-modal-header">
            <div>
                <h3 class="audit-modal-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                    <span>Request Correlation Causality Chain</span>
                </h3>
                <div id="auditTraceModalSub" style="font-size: 0.76rem; color: #64748B; margin-top: 2px;"></div>
            </div>
            <button type="button" class="dt-btn-pale" style="height:30px; padding:0 8px;" onclick="window.closeAuditModal();">&times;</button>
        </div>
        <div class="audit-modal-body" id="auditTraceModalBody">
            <!-- Loaded dynamically via AJAX -->
        </div>
        <div class="audit-modal-footer">
            <button type="button" class="dt-btn-pale" onclick="window.closeAuditModal();">Close</button>
        </div>
    </div>
</div>

<script src="/admin/audit/audit.js?v=<?php echo time(); ?>"></script>
</body>
</html>
