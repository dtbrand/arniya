<?php
/**
 * edit.php — 100% WordPress Edit Category Page (term.php replica)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Category";
$active_nav = "products";
$active_subnav = "categories";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
        .wp-edit-form-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid #c3c4c7;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
            margin-top: 10px;
        }
        .wp-edit-form-table th {
            width: 200px;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #1d2327;
            text-align: left;
            vertical-align: top;
            background: #f6f7f7;
            border-bottom: 1px solid #f0f0f1;
        }
        .wp-edit-form-table td {
            padding: 12px 16px;
            font-size: 13px;
            color: #2c3338;
            vertical-align: top;
            border-bottom: 1px solid #f0f0f1;
        }
        .wp-edit-input {
            width: 100%;
            max-width: 480px;
            height: 30px;
            padding: 0 8px;
            font-size: 13px;
            color: #2c3338;
            background: #ffffff;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            outline: none;
        }
        .wp-edit-input:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
        }
        .wp-edit-textarea {
            width: 100%;
            max-width: 480px;
            height: 80px;
            padding: 6px 8px;
            font-size: 13px;
            color: #2c3338;
            background: #ffffff;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            outline: none;
        }
        .wp-edit-textarea:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px;">

            <!-- Header -->
            <div class="wp-heading-wrap" style="justify-content: space-between;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline">Edit category</h1>
                    <a href="/Frontend/Admin/products/categories/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Product categories</span>
                    </a>
                </div>
                <div>
                    <a href="/Frontend/Admin/products/categories/view.php?id=1" class="wp-button">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>View Category</span>
                    </a>
                </div>
            </div>

            <!-- Form Table -->
            <form onsubmit="event.preventDefault(); window.showToast('✨ Category updated successfully!');">
                <table class="wp-edit-form-table">
                    <tr>
                        <th><label for="editName">Name <span style="color:#b32d2e;">*</span></label></th>
                        <td>
                            <input type="text" id="editName" class="wp-edit-input" value="Silk Sarees" required>
                            <p style="font-size:11.5px; color:#646970; margin-top:4px;">The name is how it appears on your site.</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="editSlug">Slug</label></th>
                        <td>
                            <input type="text" id="editSlug" class="wp-edit-input" value="silk-sarees">
                            <p style="font-size:11.5px; color:#646970; margin-top:4px;">The “slug” is the URL-friendly version of the name.</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="editParent">Parent category</label></th>
                        <td>
                            <select id="editParent" class="wp-edit-input" style="width: auto; min-width: 200px;">
                                <option value="" selected>None</option>
                                <option value="Silk Sarees">Silk Sarees</option>
                                <option value="Banarasi Brocade">Banarasi Brocade</option>
                                <option value="Bridal Lehengas">Bridal Lehengas</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="editDesc">Description</label></th>
                        <td>
                            <textarea id="editDesc" class="wp-edit-textarea">Pure Mulberry & Kanjivaram Bridal Silks with 24K Gold Zari Weaves.</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="editDisplay">Display type</label></th>
                        <td>
                            <select id="editDisplay" class="wp-edit-input" style="width: auto; min-width: 200px;">
                                <option value="Default" selected>Default</option>
                                <option value="Products">Products</option>
                                <option value="Subcategories">Subcategories</option>
                                <option value="Both">Both</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="editHsn">HSN Code &amp; GST</label></th>
                        <td>
                            <input type="text" id="editHsn" class="wp-edit-input" value="5007 (5% GST)">
                        </td>
                    </tr>
                    <tr>
                        <th>Thumbnail</th>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:60px; height:60px; object-fit:cover; border:1px solid #c3c4c7; border-radius:3px;" id="editThumbPreview" alt="Category Thumbnail">
                                <input type="file" id="editFileInput" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader(); r.onload=e=>document.getElementById('editThumbPreview').src=e.target.result; r.readAsDataURL(this.files[0]); window.showToast('Thumbnail updated!');}">
                                <button type="button" class="wp-button" onclick="document.getElementById('editFileInput').click()">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>Upload/Add image</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>

                <div style="margin-top:14px; display:flex; align-items:center; gap:8px;">
                    <button type="submit" class="wp-button primary" style="height:30px; padding:0 14px; font-weight:600;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Update</span>
                    </button>
                    <a href="/Frontend/Admin/products/categories/" class="wp-button" style="height:30px; line-height:28px;">Cancel</a>
                </div>
            </form>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
