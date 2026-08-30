<?php
/**
 * terms.php — DT Brand's & Jai Hanuman Tex
 * Luxury Master Terms of Wholesale, Manufacturing & Commercial Supply
 */
$pageTitle = "Terms of Wholesale & Supply — DT Brand's & Jai Hanuman Tex";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Commercial supply terms, B2B wholesale policies, MOQ guidelines, and manufacturing warranty of DT Brand's Surat." />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/home.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/policies.css?v=<?= time() ?>">
</head>
<body>

<?php include_once __DIR__ . '/includes/shophader.php'; ?>

<main class="dt-policy-wrapper">
    <!-- ════════════ MASTER LUXURY HERO BANNER ════════════ -->
    <section class="dt-policy-hero">
        <div class="dt-policy-hero-inner">
            <div class="dt-policy-breadcrumb">
                <a href="/">Home</a>
                <span class="sep">›</span>
                <span>Commercial Guidelines</span>
                <span class="sep">›</span>
                <span style="color:#FAF5E8;">Terms of Wholesale</span>
            </div>

            <div class="dt-policy-badge">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                <span>Direct Surat Loom Manufacturing Standards</span>
            </div>

            <h1 class="dt-policy-title">Terms of <span class="gold">Wholesale &amp; Supply</span></h1>
            <p class="dt-policy-subtitle">Clear commercial contracts, transparent bale lot pricing, mill dispatch agreements, and quality inspection commitments for verified B2B partners.</p>

            <div class="dt-policy-meta-strip">
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Effective: <strong>August 2026</strong></span>
                </div>
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>Compliance: <strong>Surat Textile Market Association</strong></span>
                </div>
                <div class="dt-policy-meta-item">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>Direct Factory Supply</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ MAIN POLICY LAYOUT ════════════ -->
    <div class="dt-policy-main-wrap">
        <div class="dt-policy-layout">
            
            <!-- Sidebar Quick Jump -->
            <aside class="dt-policy-sidebar">
                <div class="dt-sidebar-heading">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke-width="2.5"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    <span>Supply Agreement</span>
                </div>
                <ul class="dt-sidebar-nav">
                    <li><a href="#terms-1" class="active"><span>1. B2B Eligibility &amp; MOQs</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#terms-2"><span>2. Pricing &amp; GST Invoicing</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#terms-3"><span>3. Payment Settlement</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#terms-4"><span>4. 48-Hour Inspection &amp; Claims</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#terms-5"><span>5. Order Cancellation &amp; Holds</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    <li><a href="#terms-6"><span>6. Jurisdiction &amp; Governance</span><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                </ul>

                <div class="dt-sidebar-concierge">
                    <h4>Wholesale Assistance</h4>
                    <p>Connect directly with our Surat Mill Dealership Desk for volume quota booking.</p>
                    <a href="https://wa.me/917046363528?text=Hello%20DT%20Brand%20Mill%20Desk,%20I%20want%20to%20discuss%20wholesale%20supply%20terms." target="_blank" rel="noopener noreferrer" class="dt-btn-emerald" style="width:100%; box-sizing:border-box; font-size:0.75rem; padding:8px 12px;">
                        <span>WhatsApp B2B Desk</span>
                    </a>
                </div>
            </aside>

            <!-- Main Content Cards -->
            <div class="dt-policy-content">
                
                <!-- Card 1 -->
                <article class="dt-policy-card" id="terms-1">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">01</div>
                        <h2 class="dt-card-title">B2B Partner Eligibility &amp; Lot Lot Allocations</h2>
                    </div>
                    <p>Wholesale tier rates and master bale concessions are exclusively accessible to verified trade entities, boutique owners, multi-brand retail outlets, and certified reselling networks:</p>
                    <ul>
                        <li><strong>Minimum Order Quantities (MOQs):</strong> Catalog single designs are available per catalog specifications. Master bale orders require a minimum of <strong>10 to 50 pieces per design lot</strong> to qualify for tier factory pricing.</li>
                        <li><strong>Colour Assortments:</strong> Catalog sets are dispatched in manufacturer-packed balanced color ratios as per the original loom weaving cycle.</li>
                    </ul>

                    <div class="dt-policy-callout">
                        <div class="dt-callout-icon">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="dt-callout-text">
                            <strong>Direct Mill Price Advantage:</strong> All listed wholesale prices are direct ex-factory Surat rates, completely free from intermediate wholesaler and broker markups.
                        </div>
                    </div>
                </article>

                <!-- Card 2 -->
                <article class="dt-policy-card" id="terms-2">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">02</div>
                        <h2 class="dt-card-title">Pricing, Tax Invoicing &amp; GST Compliance</h2>
                    </div>
                    <p>All commercial transactions are governed by standard Indian textile taxation statutes:</p>
                    <ul>
                        <li><strong>GST Applicability:</strong> Goods and Services Tax (5% on standard fabric/sarees or applicable textile rates) is charged transparently and detailed on every official GST invoice.</li>
                        <li><strong>Input Tax Credit (ITC):</strong> Registered GSTIN numbers provided during checkout or onboarding are verified on the GST portal to enable 100% smooth Input Tax Credit claiming for your enterprise.</li>
                    </ul>
                </article>

                <!-- Card 3 -->
                <article class="dt-policy-card" id="terms-3">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">03</div>
                        <h2 class="dt-card-title">Payment Settlement &amp; B2B Credit Terms</h2>
                    </div>
                    <p>We support multiple verified banking channels for seamless trade settlement:</p>
                    <ul>
                        <li><strong>Instant Settlement:</strong> NEFT, RTGS, IMPS, Verified UPI, and Commercial Business Cards.</li>
                        <li><strong>Wholesale Advance Policy:</strong> Standard wholesale production runs require <strong>50% advance booking</strong> with the remaining 50% payable upon generation of the factory Lorry Receipt (LR).</li>
                        <li><strong>Credit Terms:</strong> Net-15 or Net-30 credit windows are granted solely to long-standing verified dealers with established trade turnover and formal credit clearance.</li>
                    </ul>
                </article>

                <!-- Card 4 -->
                <article class="dt-policy-card" id="terms-4">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">04</div>
                        <h2 class="dt-card-title">Quality Assurance &amp; 48-Hour Inspection Window</h2>
                    </div>
                    <p>Every handloom saree, bridal lehenga, and kurti set undergoes rigorous multi-point manual quality inspection before packaging:</p>
                    <ul>
                        <li><strong>Unboxing Requirement:</strong> In the rare event of transit damage or manufacturing discrepancy, partner must notify our desk within <strong>48 hours of parcel receipt</strong> accompanied by a continuous unboxing video proof.</li>
                        <li><strong>Manufacturing Warranty:</strong> Verified manufacturing defects are promptly replaced or credited to your partner wallet without deduction.</li>
                    </ul>
                </article>

                <!-- Card 5 -->
                <article class="dt-policy-card" id="terms-5">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">05</div>
                        <h2 class="dt-card-title">Order Modification &amp; Loom Holds</h2>
                    </div>
                    <p>Once a lot enters the mechanical jacquard or hand-embroidery loom stage, design alterations cannot be made. For cancellations requested prior to loom assignment, full wallet credit is provided.</p>
                </article>

                <!-- Card 6 -->
                <article class="dt-policy-card" id="terms-6">
                    <div class="dt-card-head">
                        <div class="dt-card-num-badge">06</div>
                        <h2 class="dt-card-title">Governing Law &amp; Legal Jurisdiction</h2>
                    </div>
                    <p>All contracts, supply orders, dealer agreements, and financial transactions entered into with <strong>DT Brand's &amp; Jai Hanuman Tex</strong> are subject to the exclusive jurisdiction of the competent courts in <strong>Surat, Gujarat, India</strong>.</p>
                    
                    <div class="dt-card-btn-row">
                        <a href="/wholesale.php" class="dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <span>Explore Wholesale Catalog</span>
                        </a>
                        <a href="https://wa.me/917046363528?text=Hello%20DT%20Brand%20Team,%20I%20agree%20to%20terms%20and%20want%20to%20place%20a%20bale%20order." target="_blank" rel="noopener noreferrer" class="dt-btn-emerald">
                            <span>Place B2B Lot Order</span>
                        </a>
                    </div>
                </article>

            </div>

        </div>
    </div>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
