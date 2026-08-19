<?php
/**
 * breadcrumbs.php — ARNIYA Admin Reusable Breadcrumbs Trail
 */
if (!isset($breadcrumbs) || !is_array($breadcrumbs)) {
    $breadcrumbs = [
        ['label' => 'Admin', 'url' => '/Admin/dashboard/'],
        ['label' => isset($page_title) ? $page_title : 'Dashboard', 'url' => '']
    ];
}
?>
<nav class="adm-breadcrumbs" aria-label="Breadcrumb">
    <ol class="adm-bc-list">
        <?php foreach ($breadcrumbs as $idx => $bc): ?>
            <li class="adm-bc-item">
                <?php if (!empty($bc['url']) && $idx < count($breadcrumbs) - 1): ?>
                    <a href="<?php echo htmlspecialchars($bc['url']); ?>" class="adm-bc-link"><?php echo htmlspecialchars($bc['label']); ?></a>
                    <span class="adm-bc-sep">/</span>
                <?php else: ?>
                    <span class="adm-bc-current" aria-current="page"><?php echo htmlspecialchars($bc['label']); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
