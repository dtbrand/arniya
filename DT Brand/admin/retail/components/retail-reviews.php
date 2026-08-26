<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-reviews.php — DT Brand's & Jai Hanuman Tex
 * Retail Reviews & Rating Analytics Component
 */
require_once __DIR__ . '/retail-data.php';
$reviews_data = getRetailReviewsSummary();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <h4 class="dt-retail-card-title">Retail Product Ratings &amp; Reviews (4.8 ★ / 1,240 Reviews)</h4>
        </div>
        <a href="/admin/reviews/" class="dt-btn dt-btn-pale dt-btn-sm">Full Reviews Suite →</a>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-retail-table">
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Customer Feedback</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews_data['reviews'] as $r): ?>
                    <tr>
                        <td><strong style="color:#181512; font-size:0.8rem;"><?php echo htmlspecialchars($r['cust']); ?></strong></td>
                        <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;"><?php echo htmlspecialchars($r['prod']); ?></span></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:2px; color:#D4AF37;">
                                <?php for ($i=0; $i<$r['rating']; $i++): ?>
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="#D4AF37"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <?php endfor; ?>
                            </div>
                        </td>
                        <td style="font-size:0.75rem; color:#4B5563; font-style:italic;">"<?php echo htmlspecialchars($r['text']); ?>"</td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $r['date']; ?></td>
                        <td><span class="dt-status-pill-clean <?php echo $r['badge']; ?>"><?php echo $r['status']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
