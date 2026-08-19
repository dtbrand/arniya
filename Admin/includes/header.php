<?php
/**
 * header.php — ARNIYA Admin Shared HTML Head & Asset Loader
 * DT Brand's & Jai Hanuman Tex
 */
if (!isset($page_title)) {
    $page_title = 'Dashboard';
}
if (!isset($active_nav)) {
    $active_nav = 'dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?php echo htmlspecialchars($page_title); ?> — ARNIYA Admin Command Center</title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="/Shared/Asset/images/logo.png" onerror="this.href='/Frontend/Shop/Asset/images/logo.png';">

    <!-- Google Fonts: Luxury Serif & Modern Clean UI Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Master Shared CSS System -->
    <link rel="stylesheet" href="/Admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Admin/assets/css/layout.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Admin/assets/css/components.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Admin/assets/css/forms.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Admin/assets/css/tables.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Admin/assets/css/responsive.css?v=<?php echo time(); ?>">

    <?php if (isset($extra_css) && is_array($extra_css)): ?>
        <?php foreach ($extra_css as $css_file): ?>
            <link rel="stylesheet" href="<?php echo htmlspecialchars($css_file); ?>?v=<?php echo time(); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="adm-body">
<div class="adm-app-layout" id="admAppLayout">
