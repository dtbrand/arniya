<?php
require_once __DIR__ . '/_shared.php';
/* DT admin access guard (auto-inserted) */ 
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; 
if (is_file($__dtg)) require_once $__dtg;

/**
 * payment.php — Master Multi-Gateway Payment Control Studio
 * DT Brand's & Jai Hanuman Tex
 * Supports: Instant UPI Deep Linking & Dynamic QR, Razorpay, Cashfree, COD, WhatsApp Pay
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\PaymentManager;
use DTBrand\Database;

$page_title = "Payment Gateways & Checkout Studio";
$active_nav = "payments";
$active_subnav = "gateways";

$gateways = PaymentManager::getAllGateways(false);
$activeTab = $_GET['tab'] ?? 'upi';

$upiGate = $gateways['direct_upi'] ?? [];
$upiCfg = $upiGate['config'] ?? [];

$rzpGate = $gateways['razorpay'] ?? [];
$rzpCfg = $rzpGate['config'] ?? [];

$cfGate = $gateways['cashfree'] ?? [];
$cfCfg = $cfGate['config'] ?? [];

$codGate = $gateways['cod'] ?? [];
$codCfg = $codGate['config'] ?? [];

$waGate = $gateways['whatsapp_pay'] ?? [];
$waCfg = $waGate['config'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateways & Checkout Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        /* Luxury Payment Studio Tabs & Components */
        .dt-pay-tab-nav {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid #E2E8F0;
            padding-bottom: 2px;
            margin-bottom: 24px;
            overflow-x: auto;
            scrollbar-width: thin;
        }
        .dt-pay-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px 8px 0 0;
            border: 1px solid transparent;
            border-bottom: none;
            background: #F8FAFC;
            color: #64748B;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
        }
        .dt-pay-tab-btn:hover {
            color: #8A681F;
            background: #FAF5E8;
        }
        .dt-pay-tab-btn.active {
            background: #FFFFFF;
            color: #8A681F;
            border-color: #D4AF37;
            border-top: 3px solid #8A681F;
            box-shadow: 0 -2px 10px rgba(138, 104, 31, 0.08);
        }
        .dt-pay-tab-pane {
            display: none;
            animation: dtTabFadeIn 0.25s ease-in-out;
        }
        .dt-pay-tab-pane.active {
            display: block;
        }
        @keyframes dtTabFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dt-webhook-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            background: #F1F5F9;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.82rem;
            color: #1E293B;
            margin-top: 6px;
        }
        .dt-copy-btn {
            background: #FAF5E8;
            border: 1px solid #D4AF37;
            color: #8A681F;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .dt-copy-btn:hover {
            background: #8A681F;
            color: #FFFFFF;
        }
        .dt-toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .dt-toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .dt-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #CBD5E1;
            transition: .3s;
            border-radius: 24px;
        }
        .dt-toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        input:checked + .dt-toggle-slider {
            background-color: #15803D;
        }
        input:checked + .dt-toggle-slider:before {
            transform: translateX(20px);
        }
        .dt-preview-qr-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 1.5px dashed #D4AF37;
            border-radius: 12px;
            background: #FAF9F5;
            text-align: center;
        }
    </style>
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
                        <span>Payment Gateways & Checkout Studio</span>
                        <span class="adm-badge gold">Production Live</span>
                    </h1>
                    <p class="adm-page-subtitle">Configure Instant Direct UPI, Dynamic QR Studio, Razorpay, Cashfree, COD & WhatsApp Pay.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/payments/" class="adm-btn-secondary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>View Ledger & Settlements</span>
                    </a>
                    <a href="/checkout.php" target="_blank" class="adm-btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        <span>Preview Storefront Checkout</span>
                    </a>
                </div>
            </div>

            <!-- Tab Navigation Strip -->
            <div class="dt-pay-tab-nav" id="paymentTabsNav">
                <button type="button" class="dt-pay-tab-btn <?= $activeTab === 'upi' ? 'active' : '' ?>" onclick="switchPayTab('upi')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                    <span>Instant UPI & QR Studio</span>
                </button>
                <button type="button" class="dt-pay-tab-btn <?= $activeTab === 'razorpay' ? 'active' : '' ?>" onclick="switchPayTab('razorpay')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span>Razorpay PG</span>
                </button>
                <button type="button" class="dt-pay-tab-btn <?= $activeTab === 'cashfree' ? 'active' : '' ?>" onclick="switchPayTab('cashfree')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>Cashfree PG</span>
                </button>
                <button type="button" class="dt-pay-tab-btn <?= $activeTab === 'cod' ? 'active' : '' ?>" onclick="switchPayTab('cod')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    <span>Cash on Delivery (COD)</span>
                </button>
                <button type="button" class="dt-pay-tab-btn <?= $activeTab === 'whatsapp' ? 'active' : '' ?>" onclick="switchPayTab('whatsapp')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    <span>WhatsApp Order & Pay</span>
                </button>
            </div>

            <!-- ══════════════════════════════════════════════════
                 TAB 1: INSTANT UPI & DYNAMIC QR STUDIO
            ══════════════════════════════════════════════════ -->
            <div class="dt-pay-tab-pane <?= $activeTab === 'upi' ? 'active' : '' ?>" id="pane-upi">
                <form id="form-direct_upi" onsubmit="saveGatewayForm(event, 'direct_upi')">
                    <div class="adm-card">
                        <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h3 class="adm-card-title"><span>⚡ Instant Direct UPI & Dynamic QR Studio</span></h3>
                                <p style="font-size:12px; color:#64748B; margin-top:3px;">Auto-opens Google Pay, PhonePe, Paytm, BHIM, CRED on mobile. Generates dynamic real-time QR on desktop with 0% processing fee.</p>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <label style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#1F2937;">
                                    <span>Active:</span>
                                    <label class="dt-toggle-switch">
                                        <input type="checkbox" name="is_active" value="1" <?= !empty($upiGate['is_active']) ? 'checked' : '' ?>>
                                        <span class="dt-toggle-slider"></span>
                                    </label>
                                </label>
                                <button type="submit" class="adm-btn-primary" style="padding:7px 16px;">Save UPI Studio</button>
                            </div>
                        </div>

                        <div class="adm-form-grid" style="padding:18px;">
                            <div class="adm-form-group">
                                <label class="adm-form-label">Primary Business UPI ID (VPA) <span style="color:#DC2626;">*</span></label>
                                <input type="text" class="adm-form-input" name="config[upi_vpa]" value="<?= htmlspecialchars($upiCfg['upi_vpa'] ?? '917046363528@okaxis') ?>" required placeholder="e.g. 917046363528@okaxis">
                                <span style="font-size:11px; color:#64748B;">Receives customer direct instant UPI transfers.</span>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Merchant / Payee Display Name <span style="color:#DC2626;">*</span></label>
                                <input type="text" class="adm-form-input" name="config[upi_name]" value="<?= htmlspecialchars($upiCfg['upi_name'] ?? "DT Brand's & Jai Hanuman Tex") ?>" required placeholder="e.g. DT Brand's & Jai Hanuman Tex">
                                <span style="font-size:11px; color:#64748B;">Shown on customer UPI app header screen.</span>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Backup / Secondary UPI ID</label>
                                <input type="text" class="adm-form-input" name="config[backup_vpa]" value="<?= htmlspecialchars($upiCfg['backup_vpa'] ?? 'dtbrands@icici') ?>" placeholder="e.g. dtbrands@icici">
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">NPCI Merchant Category Code (MCC)</label>
                                <input type="text" class="adm-form-input" name="config[mcc]" value="<?= htmlspecialchars($upiCfg['mcc'] ?? '5691') ?>" placeholder="5691 (Apparel / Textiles)">
                            </div>

                            <div class="adm-form-group" style="grid-column: 1 / -1; display:flex; flex-wrap:wrap; gap:20px; padding:12px; background:#F8FAFC; border-radius:8px; border:1px solid #E2E8F0;">
                                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" name="config[auto_open_app]" value="1" <?= !empty($upiCfg['auto_open_app']) ? 'checked' : '' ?>>
                                    <span>Auto-open GPay / PhonePe / Paytm on mobile click</span>
                                </label>
                                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" name="config[dynamic_qr]" value="1" <?= !empty($upiCfg['dynamic_qr']) ? 'checked' : '' ?>>
                                    <span>Render Dynamic QR Matrix on Desktop</span>
                                </label>
                                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" name="config[require_utr]" value="1" <?= !empty($upiCfg['require_utr']) ? 'checked' : '' ?>>
                                    <span>Ask customer for 12-digit UTR confirmation</span>
                                </label>
                                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" name="is_recommended" value="1" <?= !empty($upiGate['is_recommended']) ? 'checked' : '' ?>>
                                    <span style="color:#8A681F;">⭐ Mark as "Recommended" on Checkout</span>
                                </label>
                            </div>
                        </div>

                        <!-- Live UPI Preview & QR Simulator -->
                        <div style="margin: 0 18px 18px; padding: 16px; background: #FAF9F5; border: 1px solid #D4AF37; border-radius: 10px; display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
                            <div style="width: 110px; height: 110px; background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 8px; display: flex; align-items: center; justify-content: center; padding: 6px;">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=upi%3A%2F%2Fpay%3Fpa%3D<?= urlencode($upiCfg['upi_vpa'] ?? '917046363528@okaxis') ?>%26pn%3DDT%20Brands%26cu%3DINR" alt="Live QR Preview" style="width: 100%; height: 100%;">
                            </div>
                            <div style="flex: 1; min-width: 240px;">
                                <h4 style="margin: 0 0 4px; font-size: 0.9rem; color: #8A681F;">Live Dynamic QR Preview</h4>
                                <p style="margin: 0 0 8px; font-size: 0.78rem; color: #5A5348;">This QR code automatically calculates the exact order amount with DT Brand's VPA on customer checkout.</p>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <span style="background: #E8F5E9; color: #15803D; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">Google Pay</span>
                                    <span style="background: #EDE7F6; color: #673AB7; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">PhonePe</span>
                                    <span style="background: #E1F5FE; color: #0288D1; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">Paytm</span>
                                    <span style="background: #FFF3E0; color: #E65100; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">BHIM / CRED</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ══════════════════════════════════════════════════
                 TAB 2: RAZORPAY ONLINE PG
            ══════════════════════════════════════════════════ -->
            <div class="dt-pay-tab-pane <?= $activeTab === 'razorpay' ? 'active' : '' ?>" id="pane-razorpay">
                <form id="form-razorpay" onsubmit="saveGatewayForm(event, 'razorpay')">
                    <div class="adm-card">
                        <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h3 class="adm-card-title"><span>💳 Razorpay Payment Gateway</span></h3>
                                <p style="font-size:12px; color:#64748B; margin-top:3px;">Accept Credit/Debit Cards, NetBanking (50+ Indian Banks), UPI, Wallets, and EMI.</p>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <label style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#1F2937;">
                                    <span>Active:</span>
                                    <label class="dt-toggle-switch">
                                        <input type="checkbox" name="is_active" value="1" <?= !empty($rzpGate['is_active']) ? 'checked' : '' ?>>
                                        <span class="dt-toggle-slider"></span>
                                    </label>
                                </label>
                                <button type="submit" class="adm-btn-primary" style="padding:7px 16px;">Save Razorpay Settings</button>
                            </div>
                        </div>

                        <div class="adm-form-grid" style="padding:18px;">
                            <div class="adm-form-group">
                                <label class="adm-form-label">Environment Mode</label>
                                <select class="adm-form-input" name="is_test_mode">
                                    <option value="0" <?= empty($rzpGate['is_test_mode']) ? 'selected' : '' ?>>Live Production Mode</option>
                                    <option value="1" <?= !empty($rzpGate['is_test_mode']) ? 'selected' : '' ?>>Test / Sandbox Mode</option>
                                </select>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Razorpay Key ID</label>
                                <input type="text" class="adm-form-input" name="config[key_id]" value="<?= htmlspecialchars($rzpCfg['key_id'] ?? (getenv('RAZORPAY_KEY_ID') ?: '')) ?>" placeholder="rzp_live_...">
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Razorpay Key Secret</label>
                                <input type="password" class="adm-form-input" name="config[key_secret]" value="<?= htmlspecialchars($rzpCfg['key_secret'] ?? (getenv('RAZORPAY_KEY_SECRET') ?: '')) ?>" placeholder="••••••••••••••••">
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Razorpay Webhook Secret</label>
                                <input type="password" class="adm-form-input" name="config[webhook_secret]" value="<?= htmlspecialchars($rzpCfg['webhook_secret'] ?? (getenv('RAZORPAY_WEBHOOK_SECRET') ?: '')) ?>" placeholder="Webhook Secret for HMAC verification">
                            </div>

                            <div class="adm-form-group" style="grid-column: 1 / -1;">
                                <label class="adm-form-label">Webhook URL for Razorpay Dashboard</label>
                                <div class="dt-webhook-box">
                                    <span id="rzpWebhookUrl">https://jaihanumantex.in/api/webhooks/razorpay.php</span>
                                    <button type="button" class="dt-copy-btn" onclick="copyText('https://jaihanumantex.in/api/webhooks/razorpay.php', this)">Copy URL</button>
                                </div>
                                <span style="font-size:11px; color:#64748B; margin-top:4px; display:block;">Paste this into your Razorpay Dashboard ➔ Settings ➔ Webhooks with events: <code>payment.captured</code>, <code>order.paid</code>, <code>payment.failed</code>.</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ══════════════════════════════════════════════════
                 TAB 3: CASHFREE ONLINE PG
            ══════════════════════════════════════════════════ -->
            <div class="dt-pay-tab-pane <?= $activeTab === 'cashfree' ? 'active' : '' ?>" id="pane-cashfree">
                <form id="form-cashfree" onsubmit="saveGatewayForm(event, 'cashfree')">
                    <div class="adm-card">
                        <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h3 class="adm-card-title"><span>🚀 Cashfree Payment Gateway</span></h3>
                                <p style="font-size:12px; color:#64748B; margin-top:3px;">Accept payments via Cashfree Drop PG, Instant UPI Intent, Cards & Netbanking.</p>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <label style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#1F2937;">
                                    <span>Active:</span>
                                    <label class="dt-toggle-switch">
                                        <input type="checkbox" name="is_active" value="1" <?= !empty($cfGate['is_active']) ? 'checked' : '' ?>>
                                        <span class="dt-toggle-slider"></span>
                                    </label>
                                </label>
                                <button type="submit" class="adm-btn-primary" style="padding:7px 16px;">Save Cashfree Settings</button>
                            </div>
                        </div>

                        <div class="adm-form-grid" style="padding:18px;">
                            <div class="adm-form-group">
                                <label class="adm-form-label">Environment Mode</label>
                                <select class="adm-form-input" name="is_test_mode">
                                    <option value="0" <?= empty($cfGate['is_test_mode']) ? 'selected' : '' ?>>Production (Live)</option>
                                    <option value="1" <?= !empty($cfGate['is_test_mode']) ? 'selected' : '' ?>>Sandbox (Test)</option>
                                </select>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Cashfree App ID (Client ID)</label>
                                <input type="text" class="adm-form-input" name="config[app_id]" value="<?= htmlspecialchars($cfCfg['app_id'] ?? '') ?>" placeholder="e.g. 123456abcdef...">
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Cashfree Secret Key</label>
                                <input type="password" class="adm-form-input" name="config[secret_key]" value="<?= htmlspecialchars($cfCfg['secret_key'] ?? '') ?>" placeholder="••••••••••••••••">
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Cashfree Webhook Secret</label>
                                <input type="password" class="adm-form-input" name="config[webhook_secret]" value="<?= htmlspecialchars($cfCfg['webhook_secret'] ?? '') ?>" placeholder="Webhook Signature Verification Secret">
                            </div>

                            <div class="adm-form-group" style="grid-column: 1 / -1;">
                                <label class="adm-form-label">Webhook URL for Cashfree Dashboard</label>
                                <div class="dt-webhook-box">
                                    <span id="cfWebhookUrl">https://jaihanumantex.in/api/webhooks/cashfree.php</span>
                                    <button type="button" class="dt-copy-btn" onclick="copyText('https://jaihanumantex.in/api/webhooks/cashfree.php', this)">Copy URL</button>
                                </div>
                                <span style="font-size:11px; color:#64748B; margin-top:4px; display:block;">Paste this into Cashfree Merchant Dashboard ➔ Developers ➔ Webhooks with event: <code>PAYMENT_SUCCESS_WEBHOOK</code>.</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ══════════════════════════════════════════════════
                 TAB 4: CASH ON DELIVERY (COD)
            ══════════════════════════════════════════════════ -->
            <div class="dt-pay-tab-pane <?= $activeTab === 'cod' ? 'active' : '' ?>" id="pane-cod">
                <form id="form-cod" onsubmit="saveGatewayForm(event, 'cod')">
                    <div class="adm-card">
                        <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h3 class="adm-card-title"><span>🚚 Cash on Delivery (COD) Rules</span></h3>
                                <p style="font-size:12px; color:#64748B; margin-top:3px;">Allow customers to pay in cash upon doorstep delivery across serviceable pincodes.</p>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <label style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#1F2937;">
                                    <span>Active:</span>
                                    <label class="dt-toggle-switch">
                                        <input type="checkbox" name="is_active" value="1" <?= !empty($codGate['is_active']) ? 'checked' : '' ?>>
                                        <span class="dt-toggle-slider"></span>
                                    </label>
                                </label>
                                <button type="submit" class="adm-btn-primary" style="padding:7px 16px;">Save COD Settings</button>
                            </div>
                        </div>

                        <div class="adm-form-grid" style="padding:18px;">
                            <div class="adm-form-group">
                                <label class="adm-form-label">COD Extra Handling Fee (₹)</label>
                                <input type="number" min="0" step="1" class="adm-form-input" name="config[handling_fee]" value="<?= htmlspecialchars($codCfg['handling_fee'] ?? '0') ?>" placeholder="0 for Free COD">
                                <span style="font-size:11px; color:#64748B;">Additional courier collection fee added to order total.</span>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Minimum Order Value for COD (₹)</label>
                                <input type="number" min="0" step="1" class="adm-form-input" name="config[min_order]" value="<?= htmlspecialchars($codCfg['min_order'] ?? '299') ?>" placeholder="299">
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Maximum Order Value for COD (₹)</label>
                                <input type="number" min="0" step="1" class="adm-form-input" name="config[max_order]" value="<?= htmlspecialchars($codCfg['max_order'] ?? '25000') ?>" placeholder="25000">
                            </div>

                            <div class="adm-form-group" style="grid-column: 1 / -1; display:flex; gap:20px; padding:12px; background:#F8FAFC; border-radius:8px; border:1px solid #E2E8F0;">
                                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" name="config[verify_otp]" value="1" <?= !empty($codCfg['verify_otp']) ? 'checked' : '' ?>>
                                    <span>Require WhatsApp / Phone Verification before confirming COD</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ══════════════════════════════════════════════════
                 TAB 5: WHATSAPP ORDER & PAY
            ══════════════════════════════════════════════════ -->
            <div class="dt-pay-tab-pane <?= $activeTab === 'whatsapp' ? 'active' : '' ?>" id="pane-whatsapp">
                <form id="form-whatsapp_pay" onsubmit="saveGatewayForm(event, 'whatsapp_pay')">
                    <div class="adm-card">
                        <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h3 class="adm-card-title"><span>💬 Direct WhatsApp Order & Pay</span></h3>
                                <p style="font-size:12px; color:#64748B; margin-top:3px;">1-Click Concierge ordering routing customer directly to DT Brand's official WhatsApp.</p>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <label style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#1F2937;">
                                    <span>Active:</span>
                                    <label class="dt-toggle-switch">
                                        <input type="checkbox" name="is_active" value="1" <?= !empty($waGate['is_active']) ? 'checked' : '' ?>>
                                        <span class="dt-toggle-slider"></span>
                                    </label>
                                </label>
                                <button type="submit" class="adm-btn-primary" style="padding:7px 16px;">Save WhatsApp Settings</button>
                            </div>
                        </div>

                        <div class="adm-form-grid" style="padding:18px;">
                            <div class="adm-form-group">
                                <label class="adm-form-label">Official WhatsApp Master Number <span style="color:#DC2626;">*</span></label>
                                <input type="text" class="adm-form-input" name="config[phone]" value="<?= htmlspecialchars($waCfg['phone'] ?? '917046363528') ?>" required placeholder="917046363528">
                                <span style="font-size:11px; color:#64748B;">Format with country code: 917046363528</span>
                            </div>

                            <div class="adm-form-group" style="grid-column: 1 / -1;">
                                <label class="adm-form-label">Order Message Welcome Note</label>
                                <textarea class="adm-form-input" name="config[welcome_msg]" rows="3" placeholder="Welcome message"><?= htmlspecialchars($waCfg['welcome_msg'] ?? "Namaste! I would like to place an order from DT Brand's.") ?></textarea>
                            </div>

                            <div class="adm-form-group" style="grid-column: 1 / -1; display:flex; gap:20px; padding:12px; background:#F8FAFC; border-radius:8px; border:1px solid #E2E8F0;">
                                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" name="config[auto_upi_link]" value="1" <?= !empty($waCfg['auto_upi_link']) ? 'checked' : '' ?>>
                                    <span>Automatically embed Instant UPI Payment Deep Link in WhatsApp message</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function switchPayTab(tabId) {
    document.querySelectorAll('.dt-pay-tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.dt-pay-tab-pane').forEach(pane => pane.classList.remove('active'));
    
    const targetBtn = Array.from(document.querySelectorAll('.dt-pay-tab-btn')).find(b => b.getAttribute('onclick').includes("'" + tabId + "'"));
    if (targetBtn) targetBtn.classList.add('active');
    
    const targetPane = document.getElementById('pane-' + tabId);
    if (targetPane) targetPane.classList.add('active');

    // Update URL query parameter cleanly without reloading
    const url = new URL(window.location);
    url.searchParams.set('tab', tabId);
    window.history.replaceState({}, '', url);
}

function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const orig = btn.innerText;
        btn.innerText = 'Copied!';
        btn.style.background = '#15803D';
        btn.style.color = '#FFFFFF';
        setTimeout(() => {
            btn.innerText = orig;
            btn.style.background = '';
            btn.style.color = '';
        }, 2000);
    });
}

function saveGatewayForm(e, gatewayKey) {
    e.preventDefault();
    const form = document.getElementById('form-' + gatewayKey);
    const formData = new FormData(form);
    
    // Construct config payload
    const payload = {
        gateway_key: gatewayKey,
        is_active: form.querySelector('input[name="is_active"]')?.checked ? 1 : 0,
        is_test_mode: form.querySelector('select[name="is_test_mode"]')?.value || 0,
        is_recommended: form.querySelector('input[name="is_recommended"]')?.checked ? 1 : 0,
        config: {}
    };

    formData.forEach((val, key) => {
        if (key.startsWith('config[')) {
            const field = key.replace('config[', '').replace(']', '');
            payload.config[field] = val;
        }
    });

    // Checkbox boolean overrides for unchecked boxes
    if (gatewayKey === 'direct_upi') {
        payload.config.auto_open_app = form.querySelector('input[name="config[auto_open_app]"]')?.checked ? 1 : 0;
        payload.config.dynamic_qr = form.querySelector('input[name="config[dynamic_qr]"]')?.checked ? 1 : 0;
        payload.config.require_utr = form.querySelector('input[name="config[require_utr]"]')?.checked ? 1 : 0;
    } else if (gatewayKey === 'cod') {
        payload.config.verify_otp = form.querySelector('input[name="config[verify_otp]"]')?.checked ? 1 : 0;
    } else if (gatewayKey === 'whatsapp_pay') {
        payload.config.auto_upi_link = form.querySelector('input[name="config[auto_upi_link]"]')?.checked ? 1 : 0;
    }

    const submitBtn = form.querySelector('button[type="submit"]');
    const origText = submitBtn.innerText;
    submitBtn.innerText = 'Saving...';
    submitBtn.disabled = true;

    fetch('/api/payment/admin_save.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerText = origText;
        if (data.success) {
            alert('Settings saved successfully!');
        } else {
            alert('Error saving settings: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(err => {
        submitBtn.disabled = false;
        submitBtn.innerText = origText;
        alert('Error communicating with server: ' + err.message);
    });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>