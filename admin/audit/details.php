<?php
/**
 * details.php — Standalone Audit Event Forensic Inspector
 * DT Brand's & Jai Hanuman Tex
 * Section 35: Central Enterprise Audit Log Admin
 */

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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$log = $id > 0 ? $auditManager->getLogById($id) : null;

$page_title = $log ? "Audit Forensic #{$id}" : "Audit Event Not Found";
$active_nav = "audit";
$current_subnav = "details";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?> - DT Brand's Admin</title>
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

            <?php if (!$log): ?>
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Event Not Found</h1>
                        <p class="adm-page-subtitle">The requested audit ledger record does not exist or has been purged.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/audit/index.php" class="dt-btn-pale">&laquo; Back to Audit Ledger</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Audit Event Forensic #<?php echo $log['id']; ?></span>
                            <span class="status-pill <?php echo htmlspecialchars((string)($log['status'] ?? 'success'), ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars(ucfirst((string)($log['status'] ?? 'success')), ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </h1>
                        <p class="adm-page-subtitle">
                            Action <code><?php echo htmlspecialchars((string)$log['action'], ENT_QUOTES, 'UTF-8'); ?></code> executed on 
                            <strong><?php echo htmlspecialchars((string)$log['entity_type'], ENT_QUOTES, 'UTF-8'); ?></strong> 
                            (ID: <code><?php echo htmlspecialchars((string)$log['entity_id'], ENT_QUOTES, 'UTF-8'); ?></code>) at <?php echo htmlspecialchars((string)$log['created_at'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                    <div class="adm-page-actions" style="display:flex; gap:10px;">
                        <?php if (!empty($log['correlation_id'])): ?>
                            <button type="button" class="dt-btn-pale" onclick="window.inspectCorrelation('<?php echo htmlspecialchars((string)$log['correlation_id'], ENT_QUOTES, 'UTF-8'); ?>');">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                <span>Trace Correlation Chain</span>
                            </button>
                        <?php endif; ?>
                        <a href="/admin/audit/index.php" class="dt-btn-pale">&laquo; Return to Feed</a>
                    </div>
                </div>

                <!-- Event Details Card -->
                <div class="audit-table-card" style="margin-bottom: 24px; padding: 24px;">
                    <h3 style="font-size: 1.05rem; font-weight: 800; margin: 0 0 16px 0; color: #111827;">Metadata &amp; Execution Context</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; font-size: 0.82rem;">
                        <div>
                            <div style="color: #64748B; font-weight: 700; text-transform: uppercase; font-size: 0.72rem;">Actor Identity</div>
                            <div style="font-weight: 800; font-size: 0.95rem; color: #111827; margin-top: 2px;">
                                <?php echo htmlspecialchars((string)($log['user_name'] ?? 'system'), ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div style="color: #8A681F; font-size: 0.75rem; font-weight: 600;">Role: <?php echo htmlspecialchars((string)($log['actor_role'] ?? 'admin'), ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>

                        <div>
                            <div style="color: #64748B; font-weight: 700; text-transform: uppercase; font-size: 0.72rem;">Correlation ID</div>
                            <div style="font-weight: 700; font-family: ui-monospace, monospace; margin-top: 2px;">
                                <?php echo htmlspecialchars((string)($log['correlation_id'] ?? 'None'), ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>

                        <div>
                            <div style="color: #64748B; font-weight: 700; text-transform: uppercase; font-size: 0.72rem;">Client Network IP</div>
                            <div style="font-weight: 700; font-family: ui-monospace, monospace; margin-top: 2px;">
                                <?php echo htmlspecialchars((string)($log['ip_address'] ?? '127.0.0.1'), ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>

                        <div>
                            <div style="color: #64748B; font-weight: 700; text-transform: uppercase; font-size: 0.72rem;">Timestamp</div>
                            <div style="font-weight: 700; color: #111827; margin-top: 2px;">
                                <?php echo htmlspecialchars((string)($log['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #E2E8F0; font-size: 0.82rem;">
                        <div style="color: #64748B; font-weight: 700; text-transform: uppercase; font-size: 0.72rem;">User Agent</div>
                        <div style="font-family: ui-monospace, monospace; color: #334155; margin-top: 2px; font-size: 0.76rem;">
                            <?php echo htmlspecialchars((string)($log['user_agent'] ?? 'CLI / Automated Service'), ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    </div>

                    <?php if (!empty($log['details'])): ?>
                        <div style="margin-top: 12px; padding: 12px 16px; background: #FAFBFD; border: 1px solid #E2E8F0; border-radius: 8px;">
                            <strong>Operation Narrative:</strong> <?php echo htmlspecialchars((string)$log['details'], ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Side-by-Side State Diff Card -->
                <div class="audit-table-card" style="padding: 24px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px;">
                        <h3 style="font-size: 1.05rem; font-weight: 800; margin: 0; color: #111827;">Forensic State Diff</h3>
                        <?php if (isset($log['diff'])): ?>
                            <div style="display:flex; gap:10px; font-size: 0.76rem; font-weight: 700;">
                                <span style="color:#15803D; background:#DCFCE7; padding:2px 8px; border-radius:4px;">+ <?php echo count($log['diff']['added'] ?? []); ?> Added</span>
                                <span style="color:#B45309; background:#FEF3C7; padding:2px 8px; border-radius:4px;">~ <?php echo count($log['diff']['modified'] ?? []); ?> Modified</span>
                                <span style="color:#DC2626; background:#FEF2F2; padding:2px 8px; border-radius:4px;">- <?php echo count($log['diff']['removed'] ?? []); ?> Removed</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="diff-container">
                        <div class="diff-box">
                            <div class="diff-box-title before">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                Previous State (Prior to Action)
                            </div>
                            <pre style="margin: 0; white-space: pre-wrap; font-size:0.78rem;"><?php 
                                echo htmlspecialchars(
                                    $log['old_values'] ? json_encode($log['old_values'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : "No previous state recorded (Creation / Initial state)",
                                    ENT_QUOTES, 
                                    'UTF-8'
                                ); 
                            ?></pre>
                        </div>

                        <div class="diff-box">
                            <div class="diff-box-title after">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                New State (Resulting from Action)
                            </div>
                            <pre style="margin: 0; white-space: pre-wrap; font-size:0.78rem;"><?php 
                                echo htmlspecialchars(
                                    $log['new_values'] ? json_encode($log['new_values'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : "No subsequent state recorded (Deletion / Termination)",
                                    ENT_QUOTES, 
                                    'UTF-8'
                                ); 
                            ?></pre>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </main>
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
        <div class="audit-modal-body" id="auditTraceModalBody"></div>
        <div class="audit-modal-footer">
            <button type="button" class="dt-btn-pale" onclick="window.closeAuditModal();">Close</button>
        </div>
    </div>
</div>

<script src="/admin/audit/audit.js?v=<?php echo time(); ?>"></script>
</body>
</html>
