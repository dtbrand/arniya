<?php
/**
 * about-us.php — About DT Brand's & Jai Hanuman Tex
 * Master Heritage Story & Surat Loom Direct Manufacturing
 */
$page_title = "About Us ‹ Royal Surat Silk Handloom Heritage";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <style>
        .dt-abt-container { max-width: 960px; margin: 40px auto; padding: 0 20px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .dt-abt-card { background: #FFFFFF; border: 1.5px solid #D4AF37; border-radius: 12px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); line-height: 1.7; }
        .dt-abt-hero { background: linear-gradient(135deg, #181512 0%, #2A241E 100%); border: 2px solid #D4AF37; border-radius: 12px; padding: 30px; color: #FAF5E8; margin-bottom: 24px; text-align: center; }
    </style>
</head>
<body style="background:#FAF8F5; margin:0; padding:0; color:#181512;">

<div class="dt-abt-container">
    <div class="dt-abt-hero">
        <h1 style="font-family:'Cinzel',serif; font-size:2.2rem; margin:0 0 10px 0; color:#D4AF37;">DT Brand's &amp; Jai Hanuman Tex</h1>
        <p style="margin:0; font-size:1rem; color:#E5E1D7;">Direct Mill Handloom Craftsmanship &amp; Pure Silk Heritage from Surat, Gujarat</p>
    </div>

    <div class="dt-abt-card">
        <h2 style="font-family:'Cinzel',serif; font-size:1.4rem; color:#8A681F; margin-top:0;">Our Heritage &amp; Artisanal Legacy</h2>
        <p>Founded at the heart of Surat's legendary textile district, <strong>DT Brand's &amp; Jai Hanuman Tex</strong> stands as a premier manufacturer, wholesaler, and multi-channel exporter of pure handloom silks, authentic Banarasi zari brocades, and handcrafted bridal ensembles.</p>
        
        <h3 style="font-size:1.15rem; font-weight:800; color:#181512; margin-top:24px;">Direct Factory B2B &amp; Retail Model</h3>
        <p>By operating our own state-of-the-art weaving facilities on Surat Ring Road, we eliminate intermediate distributors. Every boutique owner, retail shopper, and authorized reseller receives master mill pricing, uncompromising silk authenticity, and rapid dispatch across India and worldwide.</p>

        <div style="margin-top:30px; padding:20px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:8px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div>
                <strong style="font-size:1.05rem; color:#181512; display:block;">Have a Custom Bulk Requirement?</strong>
                <span style="font-size:0.85rem; color:#78716C;">Connect directly with our Surat factory desk on WhatsApp.</span>
            </div>
            <a href="https://wa.me/917046363528?text=Namaste%20DT%20Brand%27s!%20I%20am%20interested%20in%20your%20pure%20silk%20wholesale%20collection." target="_blank" style="background:#15803D; color:#FFFFFF; padding:10px 20px; border-radius:8px; font-weight:800; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                <span>💬 WhatsApp Factory Desk</span>
            </a>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/includes/singelprodutbottomfotoer.php'; ?>
<?php include_once __DIR__ . '/Shared/cart.php'; ?>
<?php include_once __DIR__ . '/Shared/wishlist.php'; ?>

</body>
</html>
