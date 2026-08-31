<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * settings/_shared.php — shared loader for the four settings pages.
 * Reads every stored key from the `settings` table into $dtSettings and
 * exposes dt_set_save_button() markup conventions. Kept here so the four
 * pages stay identical in how they load and persist values.
 */
require_once __DIR__ . '/../../src/Database.php';

$dtSettings = [];
$dtSettingsLive = false;
$dtSettingsIsSuper = strtolower((string)($_SESSION['admin_user']['role'] ?? '')) === 'super_admin';

$pdoSet = Database::getConnection();
if ($pdoSet !== null && !Database::isMockMode()) {
    try {
        foreach (Database::query('SELECT key_name, `value` FROM settings') as $r) {
            $dtSettings[$r['key_name']] = (string)$r['value'];
        }
        $dtSettingsLive = true;
    } catch (\Throwable $e) {
        $dtSettingsLive = false;
    }
}

/** Stored value or fallback literal. */
function dt_set(string $key, string $fallback = ''): string
{
    global $dtSettings;
    $v = trim((string)($dtSettings[$key] ?? ''));
    return $v !== '' ? $v : $fallback;
}

/** Save button — a real POST for super admins, an honest note otherwise. */
function dt_set_save_button(): string
{
    global $dtSettingsIsSuper;
    if ($dtSettingsIsSuper) {
        return '<button class="adm-btn-primary" onclick="dtSettingsSave(this)">Save Settings</button>';
    }
    return '<span style="font-size:11.5px; color:#94A3B8; font-weight:600;">Read-only — Super Admin required</span>';
}

/** Shared save handler included by each settings page. */
function dt_set_save_script(array $keys): string
{
    $keyJson = json_encode(array_values($keys));
    return <<<HTML
<script>
function dtSettingsSave(btn) {
    var keys = {$keyJson};
    var payload = {};
    var missing = [];
    keys.forEach(function (k) {
        var el = document.getElementById('dtSet-' + k);
        if (!el) return;
        var v = el.value.trim();
        if (el.required && v === '') missing.push(k);
        payload[k] = v;
    });
    if (missing.length) { showToastSafe('⚠️ Required: ' + missing.join(', ')); return; }
    btn.disabled = true;
    fetch('/api/settings.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ settings: payload })
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
        btn.disabled = false;
        if (d && d.success === false) { showToastSafe('⚠️ ' + (d.message || 'Save failed')); return; }
        if (typeof window.showToast === 'function') window.showToast('✓ ' + (d.message || 'Settings saved.'));
    })
    .catch(function () { btn.disabled = false; showToastSafe('⚠️ Could not reach the server'); });
}
function showToastSafe(m) { if (typeof window.showToast === 'function') window.showToast(m); else alert(m); }
</script>
HTML;
}
?>
