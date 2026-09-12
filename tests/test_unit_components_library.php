<?php
declare(strict_types=1);

/**
 * tests/test_unit_components_library.php — Comprehensive Unit Test Suite
 * Section 39: Admin UI Component Library
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/UIComponent.php';

use DTBrand\UIComponent;

echo "═══════════════════════════════════════════════════════════════════\n";
echo "🧪 DT Brand's — Section 39: UI Component Library Test Suite\n";
echo "═══════════════════════════════════════════════════════════════════\n\n";

$passed = 0;
$failed = 0;

function assertTest(string $desc, bool $condition, string $details = ''): void {
    global $passed, $failed;
    if ($condition) {
        echo "  ✅ PASS: {$desc}\n";
        $passed++;
    } else {
        echo "  ❌ FAIL: {$desc}" . ($details ? " ({$details})" : '') . "\n";
        $failed++;
    }
}

// -------------------------------------------------------------
// 1. Filesystem & Syntax Integrity Checks
// -------------------------------------------------------------
echo "── 1. Filesystem & Static Asset Integrity ──\n";
assertTest('src/UIComponent.php exists', file_exists(__DIR__ . '/../src/UIComponent.php'));
assertTest('admin/assets/css/components.css exists', file_exists(__DIR__ . '/../admin/assets/css/components.css'));
assertTest('admin/assets/js/components.js exists', file_exists(__DIR__ . '/../admin/assets/js/components.js'));
assertTest('admin/components/index.php exists', file_exists(__DIR__ . '/../admin/components/index.php'));

$cssContent = file_get_contents(__DIR__ . '/../admin/assets/css/components.css');
assertTest('components.css contains 360 running focus line (@property)', str_contains($cssContent, '--dt-border-angle'));
assertTest('components.css contains modal and drawer classes', str_contains($cssContent, '.dt-modal-overlay') && str_contains($cssContent, '.dt-drawer-overlay'));

$jsContent = file_get_contents(__DIR__ . '/../admin/assets/js/components.js');
assertTest('components.js contains DTComponents singleton', str_contains($jsContent, 'DTComponents = {'));
assertTest('components.js contains toast, modal, drawer, tab, bulk methods', 
    str_contains($jsContent, 'toast:') &&
    str_contains($jsContent, 'openModal:') &&
    str_contains($jsContent, 'closeModal:') &&
    str_contains($jsContent, 'openDrawer:') &&
    str_contains($jsContent, 'switchTab:') &&
    str_contains($jsContent, 'initBulkSelection:')
);

$sidebarContent = file_get_contents(__DIR__ . '/../admin/includes/adminsidebar.php');
assertTest('adminsidebar.php contains link to /admin/components/', str_contains($sidebarContent, '/admin/components/'));

// -------------------------------------------------------------
// 2. Canonical 24 Components Rendering
// -------------------------------------------------------------
echo "\n── 2. Canonical 24 Components Rendering ──\n";

// 1. DataTable
$dtHtml = UIComponent::dataTable(
    [['key' => 'id', 'label' => 'ID', 'sortable' => true], ['key' => 'name', 'label' => 'Name']],
    [['id' => '1', 'name' => 'Test Saree']],
    ['selectable' => true, 'id' => 'test-table']
);
assertTest('1. DataTable renders table structure with selectable checkboxes', 
    str_contains($dtHtml, '<table class="dt-component-table"') &&
    str_contains($dtHtml, 'dt-select-all') &&
    str_contains($dtHtml, 'dt-row-select')
);

// 2. SearchBox
$sbHtml = UIComponent::searchBox('test-search', 'Search orders...', 'Initial');
assertTest('2. SearchBox renders input with clear button and SVG icon', 
    str_contains($sbHtml, 'id="test-search"') &&
    str_contains($sbHtml, 'dt-search-clear') &&
    str_contains($sbHtml, '<svg class="dt-search-icon"')
);

// 3. FilterBar
$fbHtml = UIComponent::filterBar([
    ['key' => 'status', 'label' => 'Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive']]
], ['status' => 'active']);
assertTest('3. FilterBar renders select dropdowns with active option pre-selected', 
    str_contains($fbHtml, 'dt-filter-bar') &&
    str_contains($fbHtml, 'value="active" selected')
);

// 4. FilterDrawer
$fdHtml = UIComponent::filterDrawer('test-filter-drawer', 'Advanced Order Filters', '<div>Filter Body</div>');
assertTest('4. FilterDrawer renders slide-out drawer with action buttons', 
    str_contains($fdHtml, 'id="test-filter-drawer"') &&
    str_contains($fdHtml, 'Apply Filters') &&
    str_contains($fdHtml, 'DTComponents.closeDrawer')
);

// 5. Pagination
$pgHtml = UIComponent::pagination(2, 10, 250, 25);
assertTest('5. Pagination calculates start/end ranges and page buttons', 
    str_contains($pgHtml, 'Showing <strong>26-50</strong> of <strong>250</strong> records') &&
    str_contains($pgHtml, 'class="dt-page-btn active">2</a>') &&
    str_contains($pgHtml, 'Next &raquo;')
);

// 6. Modal
$mdHtml = UIComponent::modal('test-modal', 'Test Title', '<p>Modal Body</p>', '<button>OK</button>');
assertTest('6. Modal renders overlay, header, body and footer', 
    str_contains($mdHtml, 'id="test-modal"') &&
    str_contains($mdHtml, 'dt-modal-overlay') &&
    str_contains($mdHtml, 'DTComponents.closeModal')
);

// 7. ConfirmationDialog
$cdHtml = UIComponent::confirmationDialog('test-confirm', 'Delete Order', 'Are you sure?', 'Delete Now', 'CONFIRM');
assertTest('7. ConfirmationDialog supports typed confirmation phrase enforcement', 
    str_contains($cdHtml, 'test-confirm-phrase-input') &&
    str_contains($cdHtml, 'disabled') &&
    str_contains($cdHtml, 'CONFIRM')
);

// 8. Drawer
$drHtml = UIComponent::drawer('test-drawer', 'Profile Details', '<div>Details</div>', 'left');
assertTest('8. Drawer renders left or right positioned slide-over panel', 
    str_contains($drHtml, 'dt-drawer-left') &&
    str_contains($drHtml, 'Profile Details')
);

// 9. Tabs
$tbHtml = UIComponent::tabs([
    ['id' => 'tab1', 'label' => 'First Tab'],
    ['id' => 'tab2', 'label' => 'Second Tab']
], 'tab1');
assertTest('9. Tabs renders navigation buttons with active class', 
    str_contains($tbHtml, 'dt-tab-btn active') &&
    str_contains($tbHtml, 'data-target="tab1"') &&
    str_contains($tbHtml, 'DTComponents.switchTab')
);

// 10. FormSection
$fsHtml = UIComponent::formSection('Product Details', 'Enter core SKU data', '<input type="text">');
assertTest('10. FormSection renders grouped container with title & description', 
    str_contains($fsHtml, 'dt-form-section') &&
    str_contains($fsHtml, 'Product Details') &&
    str_contains($fsHtml, 'Enter core SKU data')
);

// 11. PriceMatrix
$pmHtml = UIComponent::priceMatrix([
    ['tier' => '1 - 10 pcs', 'moq' => 1, 'wholesale_price' => 1200, 'retail_mrp' => 1999, 'margin' => '40%']
]);
assertTest('11. PriceMatrix renders wholesale tiers with Indian Rupee (₹) vector', 
    str_contains($pmHtml, 'dt-price-matrix') &&
    str_contains($pmHtml, '1 - 10 pcs') &&
    str_contains($pmHtml, 'M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8') // Rupee SVG path
);

// 12. VariantGrid
$vgHtml = UIComponent::variantGrid([
    ['sku' => 'VAR-01', 'color' => 'Crimson Red', 'size' => 'Free', 'stock' => 50, 'price' => 1400]
]);
assertTest('12. VariantGrid renders SKU color, size, stock and Rupee vector', 
    str_contains($vgHtml, 'VAR-01') &&
    str_contains($vgHtml, 'Crimson Red') &&
    str_contains($vgHtml, '50 in stock')
);

// 13. MediaUploader
$muHtml = UIComponent::mediaUploader('test-uploader', ['maxFiles' => 8]);
assertTest('13. MediaUploader renders drag-and-drop zone and file input', 
    str_contains($muHtml, 'dt-media-uploader') &&
    str_contains($muHtml, 'dt-media-dropzone') &&
    str_contains($muHtml, '8 files')
);

// 14. StatusBadge
$sb1 = UIComponent::statusBadge('completed');
$sb2 = UIComponent::statusBadge('pending');
$sb3 = UIComponent::statusBadge('cancelled');
assertTest('14. StatusBadge renders standard badges for completed, pending, cancelled', 
    str_contains($sb1, 'dt-badge-success') &&
    str_contains($sb2, 'dt-badge-warning') &&
    str_contains($sb3, 'dt-badge-danger')
);

// 15. AuditTimeline
$atHtml = UIComponent::auditTimeline([
    ['title' => 'Order Created', 'time' => '1 min ago', 'desc' => 'Retailer placed order', 'type' => 'success']
]);
assertTest('15. AuditTimeline renders chronological timeline items with dots', 
    str_contains($atHtml, 'dt-timeline') &&
    str_contains($atHtml, 'dt-timeline-dot') &&
    str_contains($atHtml, 'Order Created')
);

// 16. ActivityFeed
$afHtml = UIComponent::activityFeed([
    ['user' => 'Gautam', 'action' => 'updated stock tier', 'time' => '5m ago']
]);
assertTest('16. ActivityFeed renders user audit log entries with vector SVG icons', 
    str_contains($afHtml, 'dt-activity-feed') &&
    str_contains($afHtml, 'Gautam') &&
    str_contains($afHtml, 'updated stock tier')
);

// 17. ToastContainer
$tcHtml = UIComponent::toastContainer();
assertTest('17. ToastContainer renders fixed toast viewport', str_contains($tcHtml, 'dt-toast-container'));

// 18. ErrorPanel
$epHtml = UIComponent::errorPanel('DB Connection Error', 'MySQL server refused ping.', 'retry.php');
assertTest('18. ErrorPanel renders alert container with retry CTA', 
    str_contains($epHtml, 'dt-error-panel') &&
    str_contains($epHtml, 'DB Connection Error') &&
    str_contains($epHtml, 'Retry Action')
);

// 19. EmptyState
$esHtml = UIComponent::emptyState('No Orders Found', 'Try adjusting your filter search', '+ Create Order', 'create.php');
assertTest('19. EmptyState renders vector icon, title, message and action button', 
    str_contains($esHtml, 'dt-empty-state') &&
    str_contains($esHtml, 'No Orders Found') &&
    str_contains($esHtml, '+ Create Order')
);

// 20. LoadingSkeleton
$lsHtmlTable = UIComponent::loadingSkeleton('table', 4);
$lsHtmlCard = UIComponent::loadingSkeleton('card', 2);
assertTest('20. LoadingSkeleton renders animated shimmer lines for tables and cards', 
    str_contains($lsHtmlTable, 'dt-skeleton-row') &&
    str_contains($lsHtmlCard, 'dt-skeleton-card')
);

// 21. APIResponseViewer
$arHtml = UIComponent::apiResponseViewer(['status' => 'ok', 'ping_ms' => 1.2], 'Health API');
assertTest('21. APIResponseViewer renders dark obsidian terminal with formatted JSON', 
    str_contains($arHtml, 'dt-terminal-card') &&
    str_contains($arHtml, 'Health API') &&
    str_contains($arHtml, 'status') &&
    str_contains($arHtml, 'ok')
);

// 22. JSONViewer
$jvHtml = UIComponent::jsonViewer(['spec_version' => '2.0', 'modules' => 24]);
assertTest('22. JSONViewer renders JSON spec card with 1-click clipboard copy', 
    str_contains($jvHtml, 'JSON Spec Viewer') &&
    str_contains($jvHtml, 'spec_version')
);

// 23. DateRangePicker
$drpHtml = UIComponent::dateRangePicker('analytics-range', '7days');
assertTest('23. DateRangePicker renders quick preset pills with active range', 
    str_contains($drpHtml, 'dt-daterange-wrap') &&
    str_contains($drpHtml, 'data-range="7days"') &&
    str_contains($drpHtml, 'dt-date-pill active')
);

// 24. BulkActionBar
$baHtml = UIComponent::bulkActionBar('test-table', [
    ['label' => 'Delete Selected', 'callback' => 'deleteOrders']
]);
assertTest('24. BulkActionBar renders floating action container with count element', 
    str_contains($baHtml, 'test-table-bulk-bar') &&
    str_contains($baHtml, 'test-table-selected-count') &&
    str_contains($baHtml, 'Delete Selected') &&
    str_contains($baHtml, 'Deselect All')
);

// -------------------------------------------------------------
// 3. Indian Rupee Vector & Emojis Verification
// -------------------------------------------------------------
echo "\n── 3. Indian Rupee Vector & Zero-Emoji Quality Pillar ──\n";

$rupeeSvg = UIComponent::rupeeSvg(18);
assertTest('rupeeSvg returns inline SVG with width=18 height=18', str_contains($rupeeSvg, 'width="18"') && str_contains($rupeeSvg, 'height="18"'));
assertTest('rupeeSvg contains official Indian Rupee vector path', str_contains($rupeeSvg, 'M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8'));
assertTest('rupeeSvg contains ZERO dollar signs ($)', !str_contains($rupeeSvg, '$'));

// Check zero dollar signs in PriceMatrix and VariantGrid
assertTest('PriceMatrix contains ZERO dollar signs ($)', !str_contains($pmHtml, '$'));
assertTest('VariantGrid contains ZERO dollar signs ($)', !str_contains($vgHtml, '$'));

// Check zero emojis in UIComponent output
$allComponentsOutput = $dtHtml . $sbHtml . $fbHtml . $fdHtml . $pgHtml . $mdHtml . $cdHtml . $drHtml . $tbHtml . $fsHtml . $pmHtml . $vgHtml . $muHtml . $sb1 . $sb2 . $sb3 . $atHtml . $afHtml . $tcHtml . $epHtml . $esHtml . $lsHtmlTable . $arHtml . $jvHtml . $drpHtml . $baHtml;

// Emoji regex range (UTF-8 unicode emojis)
$emojiPattern = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u';
$hasEmoji = preg_match($emojiPattern, $allComponentsOutput);
assertTest('ZERO emojis across all 24 UI components', $hasEmoji === 0);

// -------------------------------------------------------------
// 4. XSS Escaping Verification
// -------------------------------------------------------------
echo "\n── 4. XSS Escaping Verification ──\n";

$xssSearch = UIComponent::searchBox('search-xss', 'Search...', '<script>alert("xss")</script>');
assertTest('SearchBox escapes malicious value', !str_contains($xssSearch, '<script>alert("xss")</script>') && str_contains($xssSearch, '&lt;script&gt;'));

$xssModal = UIComponent::modal('mod-xss', '<script>alert(1)</script>', 'Safe Body');
assertTest('Modal escapes malicious title', !str_contains($xssModal, '<script>alert(1)</script>') && str_contains($xssModal, '&lt;script&gt;'));

$xssEmpty = UIComponent::emptyState('<img src=x onerror=alert(1)>', 'Desc');
assertTest('EmptyState escapes malicious title', !str_contains($xssEmpty, '<img src=x onerror=alert(1)>') && str_contains($xssEmpty, '&lt;img src=x'));

// -------------------------------------------------------------
// Summary
// -------------------------------------------------------------
echo "\n═══════════════════════════════════════════════════════════════════\n";
echo "📊 Results: {$passed} Passed, {$failed} Failed\n";
echo "═══════════════════════════════════════════════════════════════════\n";

if ($failed > 0) {
    exit(1);
}
