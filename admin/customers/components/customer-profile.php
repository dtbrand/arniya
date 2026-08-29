<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-profile.php — Customer 360° Identity Card & Contact Tools
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../../src/Database.php';
require_once __DIR__ . '/../../../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

// Accept "42" or "CUST-42" and resolve to the numeric primary key.
$customer_id_raw = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
$customer_id = (int)preg_replace('/[^0-9]/', '', $customer_id_raw);
// view.php already loaded this row; reuse it rather than querying again.
$custData = isset($dossierCustomer)
    ? $dossierCustomer
    : ($customer_id > 0 ? CustomerManager::getById($customer_id) : null);

// When there is no such customer this used to fall back to a sample identity
// ("Pooja Sharma", with a real-format mobile) complete with tel:, mailto: and
// wa.me links — so a mistyped id produced a real-looking person an admin could
// phone. There is no placeholder now; the card says the record is missing.
$found  = ($custData !== null);
$cName  = $found ? (string)$custData['name'] : '';
$cPhone = $found ? (string)$custData['phone'] : '';
$cEmail = $found ? (string)$custData['email'] : '';
$cStatus = $found ? strtolower((string)$custData['status']) : '';
$cType  = $found ? ucfirst((string)$custData['type']) : '';
$cTier  = $found ? trim((string)$custData['tier']) : '';
$cDate  = ($found && !empty($custData['created_at'])) ? date('M d, Y', strtotime($custData['created_at'])) : '';
$cleanPhone = preg_replace('/[^0-9]/', '', $cPhone);
if (strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;

$nameParts = preg_split('/\s+/', $cName, -1, PREG_SPLIT_NO_EMPTY) ?: [];
$initials = strtoupper(
    (isset($nameParts[0]) ? substr($nameParts[0], 0, 1) : '') .
    (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : '')
);
?>

<?php if (!$found): ?>
<!-- ══ CUSTOMER NOT FOUND ══ -->
<div class="dt-cust-sidebar-card">
    <div class="dt-cust-dossier-hero">
        <div class="dt-cust-dossier-avatar" style="background:#F3F1EC; color:#8C8478;">?</div>
        <div>
            <h2 class="dt-cust-dossier-name">Customer not found</h2>
            <span class="dt-cust-id-badge" style="display:block; margin-top:4px;">
                <?php if ($customer_id_raw === ''): ?>
                    No customer id was supplied.
                <?php else: ?>
                    No account matches <?= htmlspecialchars($customer_id_raw) ?>.
                <?php endif; ?>
            </span>
        </div>
    </div>
    <p style="font-size:0.76rem; color:#645D54; line-height:1.5; margin:0;">
        This account may have been deleted, or the link may be stale. Nothing on
        this page refers to a real shopper.
    </p>
    <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale" style="width:100%;">← Back to Customers</a>
</div>
<?php else: ?>

<!-- ══ CUSTOMER IDENTITY CARD (LEFT DOSSIER COLUMN) ══ -->
<div class="dt-cust-sidebar-card">
    <div class="dt-cust-dossier-hero">
        <div class="dt-cust-dossier-avatar"><?= htmlspecialchars($initials ?: '?') ?></div>
        <div>
            <h2 class="dt-cust-dossier-name"><?= htmlspecialchars($cName !== '' ? $cName : 'Unnamed customer') ?></h2>
            <div class="dt-cust-dossier-meta">
                <?php
                // "Active Verified" used to be printed for every standing, so a
                // suspended account and a trade application still awaiting
                // approval both read as verified.
                $pillClass = $cStatus === 'active' ? 'active' : ($cStatus === 'pending' ? 'vip' : 'inactive');
                $pillText  = $cStatus === 'active' ? 'Active' : ($cStatus === 'pending' ? 'Awaiting Approval' : 'Suspended');
                ?>
                <span class="dt-status-pill <?= $pillClass ?>" style="font-size:0.65rem;">● <?= $pillText ?></span>
                <span class="dt-status-pill vip" style="font-size:0.65rem;">★ <?= htmlspecialchars($cType) ?></span>
            </div>
            <span class="dt-cust-id-badge" style="display:block; margin-top:4px;">
                #<?= (int)$customer_id ?><?= $cDate !== '' ? ' • Registered ' . htmlspecialchars($cDate) : '' ?>
            </span>
        </div>
    </div>

    <!-- Contact & Direct Communication Tools -->
    <div class="dt-cust-contact-actions">
        <?php // email is nullable in the schema, so neither row is assumed present. ?>
        <div class="dt-cust-contact-item">
            <span class="dt-cust-contact-val"><?= $cPhone !== '' ? htmlspecialchars($cPhone) : 'No phone on file' ?></span>
            <?php if ($cPhone !== ''): ?>
            <div style="display:flex; gap:4px;">
                <button type="button" class="dt-cust-contact-btn" onclick="copyToClipboard('<?= htmlspecialchars($cPhone, ENT_QUOTES) ?>', 'Phone Number')">Copy</button>
                <a href="tel:<?= rawurlencode($cPhone) ?>" class="dt-cust-contact-btn">Call</a>
            </div>
            <?php endif; ?>
        </div>

        <div class="dt-cust-contact-item">
            <span class="dt-cust-contact-val"><?= $cEmail !== '' ? htmlspecialchars($cEmail) : 'No email on file' ?></span>
            <?php if ($cEmail !== ''): ?>
            <div style="display:flex; gap:4px;">
                <button type="button" class="dt-cust-contact-btn" onclick="copyToClipboard('<?= htmlspecialchars($cEmail, ENT_QUOTES) ?>', 'Email')">Copy</button>
                <a href="mailto:<?= rawurlencode($cEmail) ?>" class="dt-cust-contact-btn">Email</a>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($cleanPhone !== ''): ?>
        <a href="https://wa.me/<?= rawurlencode($cleanPhone) ?>?text=<?= rawurlencode('Hello ' . $cName . ', welcome to DT Brand\'s') ?>" target="_blank" rel="noopener" class="dt-btn dt-btn-emerald" style="width:100%;">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#FFFFFF" stroke-width="2.3">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
            <span>1-Click WhatsApp Connect</span>
        </a>
        <?php endif; ?>
    </div>

    <!-- Quick Action Pills -->
    <div style="display:flex; flex-direction:column; gap:6px;">
        <a href="/admin/customers/edit.php?id=<?= (int)$customer_id ?>" class="dt-btn dt-btn-pale" style="width:100%;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Edit Profile Details</span>
        </a>
        <button type="button" class="dt-btn dt-btn-pale" style="width:100%;" onclick="openCustomerStatusModal('<?= (int)$customer_id ?>', '<?= htmlspecialchars($cStatus) ?>')">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Adjust Account Standing</span>
        </button>
        <?php
        // This button used to pass the sample address 'pooja.sharma92@gmail.com'
        // literally, for every customer on every profile -- the real $cEmail
        // above it was never read. It now hands off over WhatsApp, which is a
        // channel the site actually has; there is no outbound mail sender.
        ?>
        <?php if ($cleanPhone !== ''): ?>
        <button type="button" class="dt-btn dt-btn-pale" style="width:100%;"
                onclick="sendCustomerResetLink('<?= (int)$customer_id ?>', '<?= htmlspecialchars($cleanPhone, ENT_QUOTES) ?>', '<?= htmlspecialchars($cName, ENT_QUOTES) ?>')">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>Send Reset Link on WhatsApp</span>
        </button>
        <?php else: ?>
        <button type="button" class="dt-btn dt-btn-pale" style="width:100%; opacity:0.45; cursor:not-allowed;" disabled
                title="No phone number on file, so a reset link cannot be delivered">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>No Number for Reset Link</span>
        </button>
        <?php endif; ?>
    </div>

    <!-- Account Tier -->
    <div>
        <div style="font-size:0.72rem; font-weight:800; color:#78716C; text-transform:uppercase; margin-bottom:8px;">Account Tier</div>
        <?php
        // "VIP High-Value / Saree Enthusiast / Frequent Buyer" was printed on
        // every profile regardless of who it was. There is no tags table in the
        // schema, so the only real classification on a customer row is `tier`.
        ?>
        <div class="dt-cust-tags-wrap" id="dtCustTagsContainer">
            <?php if ($cTier !== ''): ?>
                <span class="dt-cust-tag-chip gold"><span><?= htmlspecialchars($cTier) ?></span></span>
            <?php else: ?>
                <span style="font-size:0.72rem; color:#8C8478;">No tier assigned</span>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
