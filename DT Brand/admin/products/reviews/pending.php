<?php
$page_title = "Pending Reviews";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Reviews — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Pending Reviews Moderation</span><span class="adm-badge rose">2 Pending</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/reviews/" class="adm-btn-secondary">← All Reviews</a>
                </div>
            </div>
            <div class="adm-table-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead><tr><th>Customer</th><th>Product</th><th>Rating</th><th>Feedback</th><th>Action</th></tr></thead>
                        <tbody>
                            <tr>
                                <td><strong>Pooja Varma</strong> (Jaipur)</td>
                                <td>Chanderi Silk Festive Saree</td>
                                <td>★★★★★ (5.0)</td>
                                <td>"The zari shine and borders look even better in real life than the photos!"</td>
                                <td>
                                    <button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Review approved & published live!')">Approve</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
