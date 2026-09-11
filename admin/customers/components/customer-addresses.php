<?php
/* DT admin access guard */ $__dtg = __DIR__ . '/../../includes/adminguard.php'; if (!is_file($__dtg)) $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-addresses.php — Customer Shipping & Billing Address Management
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../../src/Database.php';
require_once __DIR__ . '/../../../src/Auth.php';

use DTBrand\Database;
use DTBrand\Auth;

$addrCustId = (int)preg_replace('/[^0-9]/', '', isset($_GET['id']) ? (string)$_GET['id'] : '');
if ($addrCustId <= 0 && isset($customer_id)) {
    $addrCustId = (int)$customer_id;
}

$custGstin = '';
$custCompanyName = '';
if (isset($dossierCustomer) && is_array($dossierCustomer)) {
    $custGstin = (string)($dossierCustomer['gstin'] ?? '');
    $custCompanyName = (string)($dossierCustomer['name'] ?? '');
}

$addrRows = [];
$pdo = Database::getConnection();
if (!empty($dossierAddresses) && is_array($dossierAddresses)) {
    $addrRows = $dossierAddresses;
} elseif ($addrCustId > 0 && $pdo !== null && !Database::isMockMode()) {
    try {
        $addrRows = Auth::getCustomerAddresses($addrCustId);
    } catch (\Throwable $e) {
        $addrRows = [];
    }
}
?>

<style>
/* ── Admin Customer Address Book Luxury Styles ── */
.dt-addr-card {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 12px;
    position: relative;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.dt-addr-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border-color: #CBD5E1;
}
.dt-addr-card.billing-card {
    border-color: #D4AF37;
    background: linear-gradient(135deg, #FFFDF9 0%, #FAF5E8 100%);
    box-shadow: 0 4px 14px rgba(212, 175, 55, 0.12);
}
.dt-addr-card.shipping-default-card {
    border-color: #16A34A;
    background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 100%);
    box-shadow: 0 4px 14px rgba(22, 163, 74, 0.1);
}
.dt-addr-card.warehouse-card {
    border-color: #0284C7;
    background: linear-gradient(135deg, #F0F9FF 0%, #FFFFFF 100%);
    box-shadow: 0 4px 14px rgba(2, 132, 199, 0.08);
}
.dt-addr-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 6px;
    padding-bottom: 8px;
    border-bottom: 1px dashed #E2E8F0;
}
.dt-addr-card.billing-card .dt-addr-head {
    border-bottom-color: rgba(212, 175, 55, 0.35);
}
.dt-addr-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    padding: 3px 8px;
    border-radius: 6px;
}
.dt-addr-badge.gold {
    background: linear-gradient(135deg, #FAF5E8 0%, #F5ECCE 100%);
    color: #8A681F;
    border: 1px solid #D4AF37;
}
.dt-addr-badge.emerald {
    background: #DCFCE7;
    color: #15803D;
    border: 1px solid #86EFAC;
}
.dt-addr-badge.cyan {
    background: #E0F2FE;
    color: #0369A1;
    border: 1px solid #7DD3FC;
}
.dt-addr-badge.gray {
    background: #F1F5F9;
    color: #475569;
    border: 1px solid #CBD5E1;
}
.dt-addr-body {
    font-size: 0.8rem;
    color: #1F2937;
    line-height: 1.5;
}
.dt-addr-comp-name {
    font-size: 0.92rem;
    font-weight: 800;
    color: #111827;
    margin-bottom: 4px;
}
.dt-addr-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    padding-top: 10px;
    border-top: 1px solid #F1F5F9;
}
.dt-addr-act-btn {
    padding: 4px 9px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
    border: 1px solid transparent;
}
.dt-addr-act-btn.edit {
    background: #FAF5E8;
    color: #705114;
    border-color: #D4AF37;
}
.dt-addr-act-btn.edit:hover {
    background: #F5ECCE;
    color: #5A4210;
    transform: translateY(-1px);
}
.dt-addr-act-btn.ship-default {
    background: #F0FDF4;
    color: #15803D;
    border-color: #86EFAC;
}
.dt-addr-act-btn.ship-default:hover {
    background: #DCFCE7;
    transform: translateY(-1px);
}
.dt-addr-act-btn.bill-default {
    background: #FFFBEB;
    color: #B45309;
    border-color: #FCD34D;
}
.dt-addr-act-btn.bill-default:hover {
    background: #FEF3C7;
    transform: translateY(-1px);
}
.dt-addr-act-btn.del {
    background: #FEF2F2;
    color: #DC2626;
    border-color: #FECACA;
}
.dt-addr-act-btn.del:hover {
    background: #FEE2E2;
    transform: translateY(-1px);
}

/* ── Admin Address Modal ── */
.dt-adm-modal-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
    box-sizing: border-box;
}
.dt-adm-modal-box {
    background: #FFFFFF;
    border-radius: 14px;
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
    border: 1.5px solid #E2E8F0;
    box-sizing: border-box;
    animation: dtFadeInScale 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes dtFadeInScale {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.dt-adm-modal-header {
    background: linear-gradient(135deg, #FFFDF9 0%, #FAF5E8 100%);
    padding: 14px 20px;
    border-bottom: 1.5px solid #EAE5D9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.dt-adm-modal-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #111827;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dt-adm-modal-close {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #64748B;
    transition: all 0.15s ease;
}
.dt-adm-modal-close:hover {
    color: #111827;
    background: #F1F5F9;
    border-color: #CBD5E1;
}
.dt-adm-modal-body {
    padding: 18px 20px;
    overflow-y: auto;
    max-height: calc(90vh - 135px);
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.dt-adm-modal-footer {
    padding: 12px 20px;
    background: #FAF8F4;
    border-top: 1px solid #EAE5D9;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
}
.dt-adm-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
@media (max-width: 520px) {
    .dt-adm-form-row {
        grid-template-columns: 1fr;
    }
}
.dt-adm-field-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.dt-adm-field-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}
.dt-adm-field-input, .dt-adm-field-select, .dt-adm-field-textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1.2px solid #CBD5E1;
    font-size: 0.82rem;
    color: #111827;
    background: #FFFFFF;
    font-family: inherit;
    transition: border-color 0.15s ease;
}
.dt-adm-field-input:focus, .dt-adm-field-select:focus, .dt-adm-field-textarea:focus {
    outline: none;
    border-color: #D4AF37;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
}
</style>

<!-- ══ CUSTOMER ADDRESS BOOK ══ -->
<div id="dtCustAddressBookContainer">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
        <div>
            <h4 style="font-size:0.95rem; font-weight:800; color:#111827; margin:0; display:flex; align-items:center; gap:8px;">
                <span>Saved Addresses</span>
                <span id="dtCustAddressCountBadge" class="dt-cust-tab-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800; font-size:0.7rem; padding:2px 8px;">
                    <?php echo count($addrRows); ?>
                </span>
            </h4>
            <p style="font-size:0.75rem; color:#64748B; margin:3px 0 0 0;">
                Verified GST billing headquarters, default transport destinations, and warehouse hubs.
            </p>
        </div>

        <button type="button" class="dt-btn dt-btn-gold" onclick="openAdminAddAddressModal(<?php echo (int)$addrCustId; ?>)" style="padding:7px 15px; font-size:0.78rem; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Add Address</span>
        </button>
    </div>

    <?php if (count($addrRows) === 0): ?>
        <div class="dt-cust-empty-state" style="padding:36px 20px;">
            <div class="dt-cust-empty-icon">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <h4 class="dt-cust-empty-title">No Saved Addresses Found</h4>
            <p class="dt-cust-empty-sub">This customer does not have any saved addresses in the database yet.</p>
            <button type="button" class="dt-btn dt-btn-gold" onclick="openAdminAddAddressModal(<?php echo (int)$addrCustId; ?>)" style="margin-top:10px;">
                + Add Registered Address
            </button>
        </div>
    <?php else: ?>
    <div class="dt-cust-address-grid">
        <?php foreach ($addrRows as $a):
            $addrId = (int)($a['id'] ?? 0);
            $isDefault = !empty($a['is_default']);
            $type = strtolower((string)($a['address_type'] ?? 'shipping'));
            
            $isBilling = ($type === 'billing') || ($isDefault && ($type === 'work' || empty($type)));
            $isWarehouse = ($type === 'warehouse');
            $isDefaultShipping = $isDefault && !$isBilling;

            $cardClass = $isBilling ? 'billing-card' : ($isDefaultShipping ? 'shipping-default-card' : ($isWarehouse ? 'warehouse-card' : ''));
            $recipient = trim((string)($a['recipient_name'] ?? ''));
            if ($recipient === '') $recipient = $custCompanyName ?: 'Authorized Partner';
            $phone = trim((string)($a['phone'] ?? ''));
            $addr1 = trim((string)($a['address_line1'] ?? ''));
            $addr2 = trim((string)($a['address_line2'] ?? ''));
            $city = trim((string)($a['city'] ?? ''));
            $state = trim((string)($a['state'] ?? ''));
            $pin = trim((string)($a['pincode'] ?? ''));
            $cardJson = htmlspecialchars(json_encode([
                'id' => $addrId,
                'customer_id' => $addrCustId,
                'recipient_name' => $recipient,
                'phone' => $phone,
                'address_line1' => $addr1,
                'address_line2' => $addr2,
                'city' => $city,
                'state' => $state,
                'pincode' => $pin,
                'address_type' => $type,
                'is_default' => $isDefault ? 1 : 0,
                'gstin' => $custGstin
            ]), ENT_QUOTES, 'UTF-8');
        ?>
        <div class="dt-addr-card <?php echo $cardClass; ?>" id="dtAdminAddrCard-<?php echo $addrId; ?>">
            <div>
                <div class="dt-addr-head">
                    <?php if ($isBilling): ?>
                        <span class="dt-addr-badge gold">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Registered GST Billing Address</span>
                        </span>
                        <span class="dt-status-pill vip" style="font-size:0.62rem; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">Official Invoicing</span>
                    <?php elseif ($isDefaultShipping): ?>
                        <span class="dt-addr-badge emerald">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span>Default Shipping Address</span>
                        </span>
                        <span class="dt-status-pill active" style="font-size:0.62rem; font-weight:800;">Primary Dispatch</span>
                    <?php elseif ($isWarehouse): ?>
                        <span class="dt-addr-badge cyan">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <span>Warehouse / Godown Hub</span>
                        </span>
                    <?php else: ?>
                        <span class="dt-addr-badge gray">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Secondary Delivery Address</span>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="dt-addr-body" style="margin-top:10px;">
                    <div class="dt-addr-comp-name"><?php echo htmlspecialchars($recipient); ?></div>
                    <div><?php echo htmlspecialchars($addr1); ?></div>
                    <?php if ($addr2 !== ''): ?>
                        <div style="color:#64748B;"><?php echo htmlspecialchars($addr2); ?></div>
                    <?php endif; ?>
                    <div style="font-weight:600; margin-top:2px;">
                        <?php echo htmlspecialchars($city . ', ' . $state . ' — ' . $pin); ?>
                    </div>
                    <?php if ($phone !== ''): ?>
                        <div style="margin-top:4px; font-size:0.75rem; color:#475569; display:flex; align-items:center; gap:5px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span>Phone: <strong><?php echo htmlspecialchars($phone); ?></strong></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($isBilling && $custGstin !== ''): ?>
                        <div style="margin-top:5px; font-size:0.73rem; background:rgba(212,175,55,0.12); padding:3px 8px; border-radius:5px; border:1px solid rgba(212,175,55,0.3); display:inline-flex; align-items:center; gap:5px; color:#705114;">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>GSTIN: <strong><?php echo htmlspecialchars($custGstin); ?></strong></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="dt-addr-actions">
                <button type="button" class="dt-addr-act-btn edit" data-addr="<?php echo $cardJson; ?>" onclick="openAdminEditAddressModal(this)">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <span>Edit</span>
                </button>

                <?php if (!$isDefaultShipping): ?>
                    <button type="button" class="dt-addr-act-btn ship-default" onclick="setCustomerDefaultShipping(<?php echo $addrId; ?>, <?php echo (int)$addrCustId; ?>)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Set Default Shipping</span>
                    </button>
                <?php endif; ?>

                <?php if (!$isBilling): ?>
                    <button type="button" class="dt-addr-act-btn bill-default" onclick="setCustomerDefaultBilling(<?php echo $addrId; ?>, <?php echo (int)$addrCustId; ?>)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>Set as Billing</span>
                    </button>
                <?php endif; ?>

                <?php if (count($addrRows) > 1): ?>
                    <button type="button" class="dt-addr-act-btn del" onclick="deleteCustomerAddress(<?php echo $addrId; ?>, <?php echo (int)$addrCustId; ?>)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        <span>Delete</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- ══ LUXURY ADMIN ADDRESS MODAL ══ -->
<div id="dtAdminAddressModal" class="dt-adm-modal-backdrop" onclick="if(event.target===this) closeAdminAddressModal();">
    <div class="dt-adm-modal-box">
        <div class="dt-adm-modal-header">
            <h3 id="dtAdminAddressModalTitle" class="dt-adm-modal-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span>Add Customer Address</span>
            </h3>
            <button type="button" class="dt-adm-modal-close" onclick="closeAdminAddressModal()" aria-label="Close modal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <form id="dtAdminAddressForm" onsubmit="return handleAdminSaveAddress(event);">
            <input type="hidden" id="dtAdminAddrId" value="">
            <input type="hidden" id="dtAdminAddrCustId" value="<?php echo (int)$addrCustId; ?>">

            <div class="dt-adm-modal-body">
                <div class="dt-adm-form-row">
                    <div class="dt-adm-field-group">
                        <label class="dt-adm-field-label" for="dtAdminAddrType">Address Classification *</label>
                        <select id="dtAdminAddrType" class="dt-adm-field-select" required onchange="handleAdminAddrTypeChange(this.value)">
                            <option value="billing">⭐ Registered GST Billing Address</option>
                            <option value="shipping">🚚 Standard Shipping Destination</option>
                            <option value="warehouse">🏭 Warehouse / Godown Hub</option>
                            <option value="work">🏢 Commercial Office / Branch</option>
                            <option value="home">🏠 Residential Premises</option>
                        </select>
                    </div>

                    <div class="dt-adm-field-group">
                        <label class="dt-adm-field-label" for="dtAdminAddrRecipient">Company / Recipient Name *</label>
                        <input type="text" id="dtAdminAddrRecipient" class="dt-adm-field-input" placeholder="e.g. JNK Collection" required>
                    </div>
                </div>

                <div class="dt-adm-form-row">
                    <div class="dt-adm-field-group">
                        <label class="dt-adm-field-label" for="dtAdminAddrPhone">Contact Phone Number *</label>
                        <input type="tel" id="dtAdminAddrPhone" class="dt-adm-field-input" placeholder="e.g. 917046363528" required>
                    </div>

                    <div class="dt-adm-field-group">
                        <label class="dt-adm-field-label" for="dtAdminAddrGst">GSTIN (Tax ID)</label>
                        <input type="text" id="dtAdminAddrGst" class="dt-adm-field-input" placeholder="e.g. 24DADPD8939M1ZB" maxlength="15" style="text-transform:uppercase;">
                    </div>
                </div>

                <div class="dt-adm-field-group">
                    <label class="dt-adm-field-label" for="dtAdminAddrLine1">Street Address / Commercial Market Premises *</label>
                    <textarea id="dtAdminAddrLine1" class="dt-adm-field-textarea" rows="2" placeholder="Building name, shop/office number, market name, street..." required></textarea>
                </div>

                <div class="dt-adm-field-group">
                    <label class="dt-adm-field-label" for="dtAdminAddrLine2">Landmark / Transporter Hub / Area (Optional)</label>
                    <input type="text" id="dtAdminAddrLine2" class="dt-adm-field-input" placeholder="e.g. Near Ring Road Flyover, DTDC Hub">
                </div>

                <div class="dt-adm-form-row">
                    <div class="dt-adm-field-group">
                        <label class="dt-adm-field-label" for="dtAdminAddrCity">City / District *</label>
                        <input type="text" id="dtAdminAddrCity" class="dt-adm-field-input" placeholder="Surat" required>
                    </div>

                    <div class="dt-adm-field-group">
                        <label class="dt-adm-field-label" for="dtAdminAddrState">State / Union Territory *</label>
                        <select id="dtAdminAddrState" class="dt-adm-field-select" required>
                            <option value="Gujarat">Gujarat (24)</option>
                            <option value="Maharashtra">Maharashtra (27)</option>
                            <option value="Delhi">Delhi (07)</option>
                            <option value="Rajasthan">Rajasthan (08)</option>
                            <option value="Uttar Pradesh">Uttar Pradesh (09)</option>
                            <option value="Karnataka">Karnataka (29)</option>
                            <option value="Tamil Nadu">Tamil Nadu (33)</option>
                            <option value="Telangana">Telangana (36)</option>
                            <option value="West Bengal">West Bengal (19)</option>
                            <option value="Madhya Pradesh">Madhya Pradesh (23)</option>
                            <option value="Haryana">Haryana (06)</option>
                            <option value="Punjab">Punjab (03)</option>
                            <option value="Kerala">Kerala (32)</option>
                            <option value="Andhra Pradesh">Andhra Pradesh (37)</option>
                            <option value="Bihar">Bihar (10)</option>
                            <option value="Assam">Assam (18)</option>
                            <option value="Odisha">Odisha (21)</option>
                            <option value="Jharkhand">Jharkhand (20)</option>
                            <option value="Chhattisgarh">Chhattisgarh (22)</option>
                            <option value="Uttarakhand">Uttarakhand (05)</option>
                            <option value="Himachal Pradesh">Himachal Pradesh (02)</option>
                            <option value="Goa">Goa (30)</option>
                            <option value="Tripura">Tripura (16)</option>
                            <option value="Manipur">Manipur (14)</option>
                            <option value="Meghalaya">Meghalaya (17)</option>
                            <option value="Nagaland">Nagaland (13)</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh (12)</option>
                            <option value="Mizoram">Mizoram (15)</option>
                            <option value="Sikkim">Sikkim (11)</option>
                            <option value="Jammu & Kashmir">Jammu & Kashmir (01)</option>
                            <option value="Ladakh">Ladakh (38)</option>
                            <option value="Chandigarh">Chandigarh (04)</option>
                            <option value="Puducherry">Puducherry (34)</option>
                            <option value="Dadra & Nagar Haveli and Daman & Diu">Dadra & Nagar Haveli (26)</option>
                            <option value="Andaman & Nicobar">Andaman & Nicobar (35)</option>
                            <option value="Lakshadweep">Lakshadweep (31)</option>
                        </select>
                    </div>
                </div>

                <div class="dt-adm-form-row">
                    <div class="dt-adm-field-group">
                        <label class="dt-adm-field-label" for="dtAdminAddrPin">6-Digit PIN Code *</label>
                        <input type="text" id="dtAdminAddrPin" class="dt-adm-field-input" placeholder="395002" maxlength="6" pattern="[0-9]{6}" required>
                    </div>

                    <div class="dt-adm-field-group" style="justify-content:center; padding-top:16px;">
                        <label style="display:flex; align-items:center; gap:8px; font-size:0.78rem; font-weight:700; color:#1F2937; cursor:pointer;">
                            <input type="checkbox" id="dtAdminAddrDefault" style="width:16px; height:16px; accent-color:#D4AF37;">
                            <span>Set as default for this address type</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="dt-adm-modal-footer">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeAdminAddressModal()" style="padding:8px 16px;">
                    Cancel
                </button>
                <button type="submit" id="dtAdminAddrSaveBtn" class="dt-btn dt-btn-gold" style="padding:8px 20px; display:inline-flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#111827" stroke-width="2.3"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>Save Address</span>
                </button>
            </div>
        </form>
    </div>
</div>
