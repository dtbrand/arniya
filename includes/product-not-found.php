<?php
/**
 * includes/product-not-found.php — honest 404 body for product.php
 *
 * product.php used to answer a request for a product that is not in the
 * catalogue by rendering the first product it could find (`reset($products)`),
 * so /product.php?id=9999 showed a real saree's photos, price and SKU under the
 * wrong URL, and a shopper could add it to the bag believing they had opened
 * something else. This page says the product is gone and offers real ones.
 *
 * Expects: $pdpAlternatives (array of ProductCatalog rows, may be empty).
 */

$pdpAlternatives = isset($pdpAlternatives) && is_array($pdpAlternatives) ? $pdpAlternatives : [];
$pdpMissingRef = '';
foreach (['sku' => 'SKU', 'slug' => 'Product', 'id' => 'Product'] as $qsKey => $qsLabel) {
    if (!empty($_GET[$qsKey])) {
        $pdpMissingRef = $qsLabel . ' ' . trim((string)$_GET[$qsKey]);
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Product not available — DT Brand's</title>
<meta name="robots" content="noindex" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
<style>
    * { box-sizing: border-box; }
    body {
        margin: 0; background: #FAF8F5; color: #24211C;
        font-family: 'Inter', system-ui, sans-serif;
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; min-height: 100vh; padding: 28px 18px;
    }
    .p404-card {
        background: #FFFFFF; border: 1px solid #E7E1D6; border-radius: 16px;
        max-width: 720px; width: 100%; padding: 34px 26px; text-align: center;
        box-shadow: 0 12px 34px rgba(36, 33, 28, 0.07);
    }
    .p404-eyebrow {
        font-size: 0.68rem; font-weight: 800; letter-spacing: 0.14em;
        text-transform: uppercase; color: #8A681F;
    }
    .p404-title {
        font-family: 'Cinzel', serif; font-size: 1.5rem; font-weight: 700;
        margin: 10px 0 8px;
    }
    .p404-sub { font-size: 0.9rem; color: #5A5348; line-height: 1.6; margin: 0 auto 22px; max-width: 480px; }
    .p404-ref { font-weight: 800; color: #24211C; }
    .p404-actions { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
    .p404-btn {
        display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        padding: 11px 22px; border-radius: 30px; font-size: 0.82rem; font-weight: 800;
    }
    .p404-btn.primary { background: linear-gradient(135deg, #8A681F 0%, #D4AF37 100%); color: #FFFFFF; }
    .p404-btn.ghost { border: 1.5px solid #E7E1D6; color: #24211C; }
    .p404-alts { margin-top: 30px; }
    .p404-alts h2 {
        font-size: 0.72rem; font-weight: 800; letter-spacing: 0.12em;
        text-transform: uppercase; color: #5A5348; margin: 0 0 14px;
    }
    .p404-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 14px; }
    .p404-alt { text-decoration: none; color: inherit; text-align: left; }
    .p404-alt img {
        width: 100%; aspect-ratio: 3 / 4; object-fit: cover;
        border-radius: 10px; background: #F1EDE6; display: block;
    }
    .p404-alt-name {
        display: block; font-size: 0.78rem; font-weight: 600; margin-top: 7px;
        line-height: 1.35; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .p404-alt-price { font-size: 0.78rem; font-weight: 800; color: #8A681F; }
</style>
</head>
<body>
<div class="p404-card">
    <span class="p404-eyebrow">404 &middot; Not in the catalogue</span>
    <h1 class="p404-title">This product is not available</h1>
    <p class="p404-sub">
        <?php if ($pdpMissingRef !== ''): ?>
            <span class="p404-ref"><?= htmlspecialchars($pdpMissingRef) ?></span> is not in our catalogue.
            It may have been removed, or the link may be mistyped.
        <?php else: ?>
            We could not find the product you asked for. It may have been removed,
            or the link may be mistyped.
        <?php endif; ?>
    </p>
    <div class="p404-actions">
        <a class="p404-btn primary" href="/shop.php">Browse the collection</a>
        <a class="p404-btn ghost" href="/">Back to home</a>
    </div>

    <?php if ($pdpAlternatives !== []): ?>
    <div class="p404-alts">
        <h2>Currently in stock</h2>
        <div class="p404-grid">
            <?php foreach ($pdpAlternatives as $alt):
                $altImg = trim((string)($alt['image'] ?? ''));
                $altName = trim((string)($alt['name'] ?? ''));
                $altPrice = (float)($alt['price'] ?? 0);
            ?>
            <a class="p404-alt" href="/product.php?id=<?= (int)($alt['id'] ?? 0) ?>">
                <img
                    src="<?= htmlspecialchars($altImg !== '' ? $altImg : '/assets/images/no-image.svg') ?>"
                    alt="<?= htmlspecialchars($altName !== '' ? $altName : 'Product') ?>"
                    loading="lazy"
                />
                <span class="p404-alt-name"><?= htmlspecialchars($altName !== '' ? $altName : 'Untitled product') ?></span>
                <span class="p404-alt-price"><?= $altPrice > 0 ? '&#8377;' . number_format($altPrice) : 'Price on request' ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
