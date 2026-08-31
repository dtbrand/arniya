<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * broadcast.php — WhatsApp Broadcast Launcher
 * DT Brand's & Jai Hanuman Tex
 *
 * Previously claimed "Broadcast sent to 46 VIP partners!" via a toast — no
 * message was sent to anyone, and the audience counts (46/348) were literals.
 * There is no outbound WhatsApp Cloud API token wired into this install yet,
 * so this page now does the honest, useful thing:
 *   - builds the audience from the real customers table (live counts)
 *   - generates wa.me deep links for the chosen audience
 *   - says plainly that automated sending needs WHATSAPP_ACCESS_TOKEN
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "WhatsApp Broadcast Launcher";
$active_nav = "whatsapp";

$audiences = [];
$pdoWa = Database::getConnection();
if ($pdoWa !== null && !Database::isMockMode()) {
    try {
        $rows = Database::query(
            "SELECT type, COUNT(*) AS c FROM customers
             WHERE status = 'active' AND phone != ''
             GROUP BY type"
        );
        $labels = [
            'wholesale' => 'Wholesale Partners',
            'reseller'  => 'Reseller Network',
            'retailer'  => 'Retailer / Boutique',
            'retail'    => 'Retail Shoppers',
        ];
        foreach ($rows as $r) {
            $type = (string)$r['type'];
            if (!isset($labels[$type])) continue;
            $audiences[] = ['type' => $type, 'label' => $labels[$type], 'count' => (int)$r['c']];
        }
    } catch (\Throwable $e) {
        $audiences = [];
    }
}

$hasToken = trim((string)getenv('WHATSAPP_ACCESS_TOKEN')) !== ''
    && strpos((string)getenv('WHATSAPP_ACCESS_TOKEN'), 'replace') === false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Broadcast Launcher - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
    .dt-wa-out { background:#0F172A; color:#93C5FD; font-family:monospace; font-size:11px; padding:10px 12px; border-radius:6px; margin-top:10px; white-space:pre-wrap; display:none; max-height:280px; overflow:auto; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>WhatsApp Broadcast Launcher</span>
                        <span class="adm-badge gold">Campaign</span>
                    </h1>
                    <p class="adm-page-subtitle">Build an audience from the live customer directory and open WhatsApp deep links.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/whatsapp/" class="adm-btn-secondary">← Back to Whatsapp Suite</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Audience</span></h3>
                    <span class="adm-badge <?= $hasToken ? 'success' : '' ?>"><?= $hasToken ? 'Cloud API token detected' : 'Manual mode (no Cloud API token)' ?></span>
                </div>
                <div style="padding:0 18px 16px;">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Audience (from live customers table)</label>
                        <select class="adm-form-select" id="dtWaAudience">
                            <?php if (empty($audiences)): ?>
                                <option value="">No active customers with phone numbers yet</option>
                            <?php else: ?>
                                <?php foreach ($audiences as $a): ?>
                                    <option value="<?= htmlspecialchars($a['type']) ?>"><?= htmlspecialchars($a['label']) ?> (<?= (int)$a['count'] ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Message</label>
                        <textarea id="dtWaMsg" class="adm-form-input" rows="3" placeholder="e.g. Namaste ji! New Kanjivaram lot just landed — reply to book your picks.">Namaste ji! New Kanjivaram &amp; Banarasi lots just landed at the Surat depot. Reply here to book your picks at trade pricing.</textarea>
                    </div>
                    <button class="adm-btn-primary" onclick="buildBroadcast()">Build wa.me Links</button>
                    <div id="dtWaOut" class="dt-wa-out"></div>
                    <?php if (!$hasToken): ?>
                    <p style="font-size:11.5px; color:#B45309; margin-top:10px;">
                        ⚠ Automated sending requires WHATSAPP_ACCESS_TOKEN (Meta Cloud API) in the server's .env. Without it,
                        this tool generates one-tap wa.me links you can click through manually — no message is ever
                        claimed as "sent" when it was not.
                    </p>
                    <?php endif; ?>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function buildBroadcast() {
    var type = document.getElementById('dtWaAudience').value;
    var msg = document.getElementById('dtWaMsg').value.trim();
    var out = document.getElementById('dtWaOut');
    if (!type) { return; }
    out.style.display = 'block';
    out.textContent = 'Loading audience…';
    fetch('/api/whatsapp/audience.php?type=' + encodeURIComponent(type), { credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d && d.success === false) { out.textContent = '⚠ ' + (d.message || 'Failed'); return; }
            var lines = [];
            (d.customers || []).forEach(function (c) {
                var phone = String(c.phone || '').replace(/[^0-9]/g, '');
                if (phone.length === 10) phone = '91' + phone;
                lines.push(c.name + ' — https://wa.me/' + phone + '?text=' + encodeURIComponent(msg));
            });
            out.textContent = lines.length ? lines.join("\n") : 'No matching customers.';
        })
        .catch(function () { out.textContent = '⚠ Could not reach the server.'; });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>