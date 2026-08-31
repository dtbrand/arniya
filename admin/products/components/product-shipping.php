<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-shipping.php — What the shop actually charges for delivery
 * DT Brand's & Jai Hanuman Tex
 *
 * This section used to hold three inputs — Dead Weight "750 grams (0.75 kg)",
 * Dimensions "35 x 25 x 5 cm" and a Shipping Class select defaulting to
 * "Standard Textile Express (Air/Surface)" — hardcoded into the markup with no
 * id, no name and no matching column on `products`. Every saree in the
 * catalogue therefore displayed the same parcel specs, an admin who corrected
 * them saw the edit vanish on reload, and no courier, invoice or checkout total
 * ever read a gram of it.
 *
 * Freight is not per product in this shop: api/cart.php charges one flat rate
 * for the whole cart and waives it above a threshold. Those two numbers live in
 * config/shipping.php, so they are read from there below instead of being
 * retyped here — a panel that quotes the config cannot drift from it.
 *
 * Storing real weights and dimensions would need new columns on `products` plus
 * a rate table; until that exists, this panel states the rule rather than
 * offering boxes that pretend to change it.
 */
$shipCfgFile = __DIR__ . '/../../../config/shipping.php';
$shipCfg = is_file($shipCfgFile) ? require $shipCfgFile : [];
$shipCfg = is_array($shipCfg) ? $shipCfg : [];
$shipRate = (float)($shipCfg['standard_rate'] ?? 0);
$shipFree = (float)($shipCfg['free_shipping_threshold'] ?? 0);
$shipCourierKey = (string)($shipCfg['default_courier'] ?? '');
$shipCouriers = (array)($shipCfg['couriers'] ?? []);
$shipCourier = (string)($shipCouriers[$shipCourierKey]['name'] ?? $shipCourierKey);
$inr = static fn(float $v): string => '&#8377;' . number_format($v, 0);
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span>Delivery &amp; Freight</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <p style="font-size:11.5px; color:#3c434a; margin:0 0 10px; line-height:1.55;">
            Delivery is charged <strong>per order</strong>, not per product, so there is nothing to set
            here for this saree.
        </p>
        <ul style="margin:0; padding-left:16px; font-size:11.5px; color:#3c434a; line-height:1.7;">
            <?php if ($shipRate > 0): ?>
                <li>Flat rate <strong><?php echo $inr($shipRate); ?></strong> per order.</li>
            <?php endif; ?>
            <?php if ($shipFree > 0): ?>
                <li>Free above <strong><?php echo $inr($shipFree); ?></strong> (cart subtotal, before GST).</li>
            <?php endif; ?>
            <?php if ($shipCourier !== ''): ?>
                <li>Default courier <strong><?php echo htmlspecialchars($shipCourier); ?></strong>.</li>
            <?php endif; ?>
            <?php if ($shipRate <= 0 && $shipFree <= 0): ?>
                <li>config/shipping.php is missing or empty, so no rate is configured.</li>
            <?php endif; ?>
        </ul>
        <p style="font-size:10.5px; color:#646970; margin:10px 0 0; line-height:1.55;">
            Change these in <code>config/shipping.php</code>. Per-parcel weight, dimensions and shipping
            class are not stored yet — the boxes that used to sit here were fixed text on every product
            and were never saved.
        </p>
    </div>
</div>
