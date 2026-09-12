<?php
declare(strict_types=1);

/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * create.php - Manual order creation console.
 */

$page_title = 'Create Manual Order';
$active_nav = 'orders';
$active_subnav = 'create';

require_once __DIR__ . '/../../src/ProductCatalog.php';

use DTBrand\ProductCatalog;

$products = ProductCatalog::getAll(true);
$productPayload = array_map(static function (array $p): array {
    return [
        'id' => (int)($p['id'] ?? 0),
        'sku' => (string)($p['sku'] ?? ''),
        'name' => (string)($p['name'] ?? ($p['title'] ?? 'Product')),
        'selling_type' => (string)($p['selling_type'] ?? 'single_piece'),
        'stock_qty' => (int)($p['stock_qty'] ?? ($p['stock'] ?? 0)),
        'customer_price' => (float)($p['customer_price'] ?? $p['retail_price'] ?? 0),
        'retail_price' => (float)($p['retail_price'] ?? 0),
        'retailer_price' => (float)($p['retailer_price'] ?? $p['retail_price'] ?? 0),
        'wholesale_price' => (float)($p['wholesale_price'] ?? 0),
        'reseller_price' => (float)($p['reseller_price'] ?? 0),
        'full_set_pieces' => (int)($p['full_set_pieces'] ?? 1),
        'wholesaler_mcq' => (int)($p['wholesaler_mcq'] ?? 0),
    ];
}, $products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Manual Order - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <style>
        .dt-create-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(280px, 0.55fr);
            gap: 16px;
            align-items: start;
        }
        .dt-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 12px;
        }
        .dt-field label {
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
            font-weight: 800;
            color: #705114;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        .dt-field input,
        .dt-field select,
        .dt-field textarea {
            width: 100%;
            min-height: 38px;
            padding: 8px 10px;
            border: 1.2px solid #E5E1D7;
            border-radius: 8px;
            background: #FFFFFF;
            color: #111827;
            font: 600 13px 'Inter', 'Plus Jakarta Sans', sans-serif;
        }
        .dt-field textarea {
            min-height: 80px;
            resize: vertical;
        }
        .dt-line-items {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .dt-line-row {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) 90px 116px 110px 38px;
            gap: 8px;
            align-items: center;
            padding: 9px;
            border: 1px solid #E5E1D7;
            border-radius: 8px;
            background: #FAF8F4;
        }
        .dt-money-cell {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            font-weight: 800;
            color: #111827;
        }
        .dt-money-cell svg {
            width: 13px;
            height: 13px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.2;
        }
        .dt-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 9px 0;
            border-bottom: 1px dashed #E5E1D7;
            color: #334155;
            font-weight: 700;
        }
        .dt-summary-row strong {
            color: #111827;
            font-size: 15px;
        }
        .dt-create-alert {
            display: none;
            margin-bottom: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }
        .dt-create-alert.success {
            display: block;
            background: #DCFCE7;
            color: #166534;
            border: 1px solid #BBF7D0;
        }
        .dt-create-alert.error {
            display: block;
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }
        @media (max-width: 1024px) {
            .dt-create-grid {
                grid-template-columns: 1fr;
            }
            .dt-line-row {
                grid-template-columns: 1fr 86px 100px 100px 38px;
            }
        }
        @media (max-width: 680px) {
            .dt-line-row {
                grid-template-columns: 1fr 76px;
            }
            .dt-line-row .dt-price-preview,
            .dt-line-row .dt-line-total,
            .dt-line-row .dt-remove-wrap {
                grid-column: span 1;
            }
        }
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
                        <span>Create Manual Order</span>
                        <span class="adm-badge gold">Admin Checkout</span>
                    </h1>
                    <p class="adm-page-subtitle">Create a verified back-office order using the same pricing and stock engine as checkout.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/orders/" class="dt-btn dt-btn-pale">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Orders</span>
                    </a>
                </div>
            </div>

            <div id="dtCreateOrderAlert" class="dt-create-alert"></div>

            <form id="dtCreateOrderForm" class="dt-create-grid">
                <section class="adm-card">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title">Order Details</h3>
                    </div>
                    <div class="dt-form-grid">
                        <div class="dt-field">
                            <label for="customerName">Customer Name</label>
                            <input id="customerName" name="customer_name" type="text" placeholder="Registered business or buyer name" required>
                        </div>
                        <div class="dt-field">
                            <label for="customerPhone">Customer Phone</label>
                            <input id="customerPhone" name="customer_phone" type="tel" placeholder="10 digit mobile number" required>
                        </div>
                        <div class="dt-field">
                            <label for="customerEmail">Customer Email</label>
                            <input id="customerEmail" name="customer_email" type="email" placeholder="billing@example.com">
                        </div>
                        <div class="dt-field">
                            <label for="orderChannel">Channel</label>
                            <select id="orderChannel" name="channel">
                                <option value="retail">Retail Customer</option>
                                <option value="wholesale">Wholesale</option>
                                <option value="retailer">Retailer</option>
                                <option value="reseller">Reseller</option>
                                <option value="whatsapp">WhatsApp Order</option>
                            </select>
                        </div>
                        <div class="dt-field">
                            <label for="paymentMethod">Payment Method</label>
                            <select id="paymentMethod" name="payment_method">
                                <option value="direct_upi">Direct UPI</option>
                                <option value="razorpay">Razorpay</option>
                                <option value="cashfree">Cashfree</option>
                                <option value="cod">Cash on Delivery</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="whatsapp_pay">WhatsApp Pay</option>
                            </select>
                        </div>
                        <div class="dt-field">
                            <label for="paymentStatus">Payment Status</label>
                            <select id="paymentStatus" name="payment_status">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="credit">Trade Credit</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="dt-field">
                            <label for="fulfillmentStatus">Fulfillment Status</label>
                            <select id="fulfillmentStatus" name="fulfillment_status">
                                <option value="unfulfilled">Unfulfilled</option>
                                <option value="processing">Processing</option>
                                <option value="dispatched">Dispatched</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="dt-field">
                            <label for="shippingFee">Shipping Fee</label>
                            <input id="shippingFee" name="shipping" type="number" min="0" step="0.01" value="0">
                        </div>
                        <div class="dt-field">
                            <label for="gstRate">GST Rate</label>
                            <input id="gstRate" name="gst_rate" type="number" min="0" max="28" step="0.01" value="5">
                        </div>
                    </div>

                    <div class="dt-field" style="margin-top:12px;">
                        <label for="shippingAddress">Shipping Address</label>
                        <textarea id="shippingAddress" name="shipping_address" placeholder="Complete delivery address"></textarea>
                    </div>
                </section>

                <aside class="adm-card">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title">Order Summary</h3>
                    </div>
                    <div class="dt-summary-row">
                        <span>Items</span>
                        <strong id="summaryItems">0</strong>
                    </div>
                    <div class="dt-summary-row">
                        <span>Subtotal</span>
                        <strong class="dt-money-cell"><svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg><span id="summarySubtotal">0</span></strong>
                    </div>
                    <div class="dt-summary-row">
                        <span>GST</span>
                        <strong class="dt-money-cell"><svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg><span id="summaryGst">0</span></strong>
                    </div>
                    <div class="dt-summary-row">
                        <span>Shipping</span>
                        <strong class="dt-money-cell"><svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg><span id="summaryShipping">0</span></strong>
                    </div>
                    <div class="dt-summary-row" style="border-bottom:0;">
                        <span>Estimated Total</span>
                        <strong class="dt-money-cell" style="font-size:18px; color:#8A681F;"><svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg><span id="summaryTotal">0</span></strong>
                    </div>
                    <button type="submit" class="dt-btn dt-btn-gold" style="width:100%; height:40px; margin-top:12px;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                        <span>Create Order</span>
                    </button>
                </aside>

                <section class="adm-card" style="grid-column:1 / -1;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title">Line Items</h3>
                        <button type="button" class="dt-btn dt-btn-pale" id="addLineBtn">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add Item</span>
                        </button>
                    </div>
                    <?php if (empty($productPayload)): ?>
                        <div style="padding:16px; border:1px dashed #D4AF37; border-radius:8px; background:#FAF5E8; color:#705114; font-weight:700;">No products are available from the database. Order creation will be ready after the product catalog connection is restored.</div>
                    <?php endif; ?>
                    <div id="lineItems" class="dt-line-items"></div>
                </section>
            </form>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script>
window.DT_ORDER_PRODUCTS = <?php echo json_encode($productPayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;

(function() {
    'use strict';

    const products = Array.isArray(window.DT_ORDER_PRODUCTS) ? window.DT_ORDER_PRODUCTS : [];
    const lineItems = document.getElementById('lineItems');
    const form = document.getElementById('dtCreateOrderForm');
    const addLineBtn = document.getElementById('addLineBtn');
    const channelEl = document.getElementById('orderChannel');
    const shippingEl = document.getElementById('shippingFee');
    const gstEl = document.getElementById('gstRate');
    const alertEl = document.getElementById('dtCreateOrderAlert');
    let lineSeq = 0;

    function money(n) {
        return Number(n || 0).toLocaleString('en-IN', { maximumFractionDigits: 2 });
    }

    function productPrice(product, channel) {
        if (!product) return 0;
        if (channel === 'wholesale') return Number(product.wholesale_price || product.retail_price || product.customer_price || 0);
        if (channel === 'reseller') return Number(product.reseller_price || product.retail_price || product.customer_price || 0);
        if (channel === 'retailer') return Number(product.retailer_price || product.retail_price || product.customer_price || 0);
        return Number(product.customer_price || product.retail_price || 0);
    }

    function getProduct(id) {
        return products.find(function(p) { return String(p.id) === String(id); }) || null;
    }

    function rowTemplate() {
        lineSeq += 1;
        const options = ['<option value="">Select product</option>'].concat(products.map(function(p) {
            const label = (p.sku ? p.sku + ' - ' : '') + p.name;
            return '<option value="' + p.id + '">' + escapeHtml(label) + '</option>';
        })).join('');

        const row = document.createElement('div');
        row.className = 'dt-line-row';
        row.dataset.line = String(lineSeq);
        row.innerHTML =
            '<select class="dt-line-product" required>' + options + '</select>' +
            '<input class="dt-line-qty" type="number" min="1" step="1" value="1" required>' +
            '<div class="dt-money-cell dt-price-preview"><svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg><span>0</span></div>' +
            '<div class="dt-money-cell dt-line-total"><svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg><span>0</span></div>' +
            '<div class="dt-remove-wrap"><button type="button" class="dt-btn dt-btn-pale dt-line-remove" title="Remove item" style="width:32px;height:32px;padding:0;"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button></div>';

        row.querySelector('.dt-line-product').addEventListener('change', recalc);
        row.querySelector('.dt-line-qty').addEventListener('input', recalc);
        row.querySelector('.dt-line-remove').addEventListener('click', function() {
            row.remove();
            if (!lineItems.children.length && products.length) addLine();
            recalc();
        });

        return row;
    }

    function escapeHtml(text) {
        return String(text || '').replace(/[&<>"']/g, function(ch) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[ch];
        });
    }

    function addLine() {
        if (!products.length) return;
        lineItems.appendChild(rowTemplate());
        recalc();
    }

    function recalc() {
        const channel = channelEl.value || 'retail';
        let subtotal = 0;
        let itemCount = 0;

        lineItems.querySelectorAll('.dt-line-row').forEach(function(row) {
            const product = getProduct(row.querySelector('.dt-line-product').value);
            const qty = Math.max(1, Number(row.querySelector('.dt-line-qty').value || 1));
            const unit = productPrice(product, channel);
            const pieces = product && product.selling_type === 'full_set' ? Math.max(1, Number(product.full_set_pieces || 1)) : 1;
            const total = unit * qty * pieces;
            row.querySelector('.dt-price-preview span').textContent = money(unit);
            row.querySelector('.dt-line-total span').textContent = money(total);
            if (product) {
                subtotal += total;
                itemCount += qty;
            }
        });

        const shipping = Math.max(0, Number(shippingEl.value || 0));
        const gstRate = Math.max(0, Number(gstEl.value || 0));
        const gst = subtotal * gstRate / 100;
        const total = subtotal + gst + shipping;

        document.getElementById('summaryItems').textContent = String(itemCount);
        document.getElementById('summarySubtotal').textContent = money(subtotal);
        document.getElementById('summaryGst').textContent = money(gst);
        document.getElementById('summaryShipping').textContent = money(shipping);
        document.getElementById('summaryTotal').textContent = money(total);
    }

    function showAlert(message, type) {
        alertEl.className = 'dt-create-alert ' + (type || 'error');
        alertEl.textContent = message;
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const items = [];
        const channel = channelEl.value || 'retail';

        lineItems.querySelectorAll('.dt-line-row').forEach(function(row) {
            const product = getProduct(row.querySelector('.dt-line-product').value);
            if (!product) return;
            const qty = Math.max(1, parseInt(row.querySelector('.dt-line-qty').value || '1', 10));
            items.push({
                id: product.id,
                quantity: qty,
                price: productPrice(product, channel)
            });
        });

        if (!items.length) {
            showAlert('Add at least one valid product before creating the order.', 'error');
            return;
        }

        const payload = {
            action: 'create',
            customer_name: document.getElementById('customerName').value.trim(),
            customer_phone: document.getElementById('customerPhone').value.trim(),
            customer_email: document.getElementById('customerEmail').value.trim(),
            shipping_address: document.getElementById('shippingAddress').value.trim(),
            channel: channel,
            is_trade_order: ['wholesale', 'retailer'].includes(channel),
            payment_method: document.getElementById('paymentMethod').value,
            payment_status: document.getElementById('paymentStatus').value,
            fulfillment_status: document.getElementById('fulfillmentStatus').value,
            shipping: Math.max(0, Number(shippingEl.value || 0)),
            gst_rate: Math.max(0, Number(gstEl.value || 0)),
            items: items
        };

        const headers = new Headers({ 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' });
        if (window.DT_ADMIN_CSRF_TOKEN) headers.set('X-CSRF-Token', window.DT_ADMIN_CSRF_TOKEN);

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg><span>Creating...</span>';

        fetch('/api/orders.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: headers,
            body: JSON.stringify(payload)
        })
        .then(function(response) { return response.json().then(function(data) { return { ok: response.ok, data: data }; }); })
        .then(function(result) {
            if (!result.ok || !result.data.success) {
                throw new Error(result.data.message || 'Order creation failed.');
            }
            const order = result.data.order || {};
            showAlert('Order created successfully: ' + (order.order_number || 'new order'), 'success');
            setTimeout(function() {
                window.location.href = '/admin/orders/view.php?id=' + encodeURIComponent(order.order_number || order.id || '');
            }, 700);
        })
        .catch(function(error) {
            showAlert(error.message || 'Order creation failed.', 'error');
        })
        .finally(function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHtml;
        });
    });

    [channelEl, shippingEl, gstEl].forEach(function(el) { el.addEventListener('input', recalc); el.addEventListener('change', recalc); });
    addLineBtn.addEventListener('click', addLine);
    addLine();
})();
</script>
</body>
</html>
