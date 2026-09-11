<?php
/**
 * test_unit_reports_admin.php — Comprehensive Unit Test Suite for Reports & Analytics Admin (Section 33)
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */

require_once __DIR__ . '/../src/ReportManager.php';
use DTBrand\ReportManager;

$passed = 0;
$failed = 0;
$testNum = 0;

function assertTest($condition, $message) {
    global $passed, $failed, $testNum;
    $testNum++;
    if ($condition) {
        $passed++;
        echo "  [PASS] #$testNum: $message\n";
    } else {
        $failed++;
        echo "  [FAIL] #$testNum: $message\n";
    }
}

echo "========================================================================\n";
echo "  REPORTS & ANALYTICS ADMIN (SECTION 33) UNIT TESTS\n";
echo "========================================================================\n\n";

// --- 1. Export Permission & Security ---
echo "--- Group 1: Export Permission & Security ---\n";
assertTest(ReportManager::checkExportPermission() === true, "CLI environment automatically grants export permission for test harnesses");

$_SESSION['admin_logged_in'] = true;
assertTest(ReportManager::checkExportPermission() === true, "Session with admin_logged_in=true is authorized");
unset($_SESSION['admin_logged_in']);

// --- 2. CSV Injection Sanitization ---
echo "\n--- Group 2: CSV Injection Sanitization ---\n";
assertTest(ReportManager::sanitizeCsvValue("=cmd|' /C calc'!A0") === "'=cmd|' /C calc'!A0", "Formula starting with '=' is safely escaped with leading quote");
assertTest(ReportManager::sanitizeCsvValue("+12345") === "'+12345", "Formula starting with '+' is safely escaped");
assertTest(ReportManager::sanitizeCsvValue("-SUM(A1:A10)") === "'-SUM(A1:A10)", "Formula starting with '-' is safely escaped");
assertTest(ReportManager::sanitizeCsvValue("@HYPERLINK('bad.com')") === "'@HYPERLINK('bad.com')", "Formula starting with '@' is safely escaped");
assertTest(ReportManager::sanitizeCsvValue("Pure Silk Saree") === "Pure Silk Saree", "Normal text is preserved unmodified");
assertTest(ReportManager::sanitizeCsvValue(4500) === "4500", "Numeric values are converted safely to string");

// --- 3. Date Range Parsing ---
echo "\n--- Group 3: Date Range Parsing ---\n";
[$sAll, $eAll] = ReportManager::parseDateRange('all');
assertTest(strpos($sAll, '2020-01-01') === 0, "Range 'all' starts at 2020-01-01");

[$sToday, $eToday] = ReportManager::parseDateRange('today');
$expectedToday = (new \DateTime('now', new \DateTimeZone('Asia/Kolkata')))->format('Y-m-d');
assertTest($expectedToday === substr($sToday, 0, 10), "Range 'today' starts at today's date ($expectedToday)");

[$s7d, $e7d] = ReportManager::parseDateRange('7d');
assertTest(strtotime($s7d) < strtotime($e7d), "Range '7d' start date is before end date");

[$sMtd, $eMtd] = ReportManager::parseDateRange('mtd');
assertTest(date('Y-m-01') === substr($sMtd, 0, 10), "Range 'mtd' starts on first day of month");

// --- 4. Summary KPIs ---
echo "\n--- Group 4: Summary KPIs ---\n";
$kpis = ReportManager::getSummaryKpis('all');
assertTest(is_array($kpis), "Summary KPIs returns array");
assertTest(isset($kpis['gross_revenue']) && $kpis['gross_revenue'] > 0, "Gross revenue is positive");
assertTest(isset($kpis['total_orders']) && $kpis['total_orders'] > 0, "Total orders count is positive");
assertTest(isset($kpis['aov']) && $kpis['aov'] > 0, "Average Order Value (AOV) is positive");
assertTest(isset($kpis['gross_profit']) && $kpis['gross_profit'] > 0, "Gross profit is calculated");
assertTest(isset($kpis['net_profit']) && $kpis['net_profit'] > 0, "Net profit is calculated");
assertTest(isset($kpis['total_customers']) && $kpis['total_customers'] > 0, "Total customers count is present");
assertTest(isset($kpis['total_products']) && $kpis['total_products'] > 0, "Total products count is present");
assertTest(isset($kpis['return_rate']) && $kpis['return_rate'] >= 0, "Return rate % is calculated");

// --- 5. Sales Report & Channel Analytics ---
echo "\n--- Group 5: Sales Report & Channel Analytics ---\n";
$sales = ReportManager::getSalesReport('all');
assertTest(is_array($sales), "Sales report returns array");
assertTest(isset($sales['total_revenue']) && $sales['total_revenue'] > 0, "Sales total revenue is positive");
assertTest(isset($sales['channels']) && count($sales['channels']) === 4, "Sales report includes exactly 4 channels");
assertTest(isset($sales['channels']['wholesale']['name']), "Wholesale channel is defined");
assertTest(isset($sales['channels']['retailer']['name']), "Retailer channel is defined");
assertTest(isset($sales['channels']['reseller']['name']), "Reseller channel is defined");
assertTest(isset($sales['channels']['retail']['name']), "Retail channel is defined");
assertTest($sales['channels']['wholesale']['revenue'] > 0, "Wholesale revenue is recorded");
assertTest($sales['channels']['wholesale']['share'] > 0, "Wholesale share is calculated");
assertTest(is_array($sales['trend']), "Sales daily trend array is present");

// Test Channel Filter
$filteredSales = ReportManager::getSalesReport('all', 'wholesale');
assertTest(is_array($filteredSales), "Filtered sales query runs cleanly");

// --- 6. Orders Funnel Report ---
echo "\n--- Group 6: Orders Funnel Report ---\n";
$orders = ReportManager::getOrdersReport('all');
assertTest(is_array($orders), "Orders report returns array");
assertTest(isset($orders['total_orders']) && $orders['total_orders'] > 0, "Total orders count is present");
assertTest(isset($orders['funnel']) && count($orders['funnel']) === 7, "Funnel has 7 standard fulfillment stages");
assertTest(isset($orders['funnel']['new']['count']), "Funnel has 'new' stage");
assertTest(isset($orders['funnel']['processing']['count']), "Funnel has 'processing' stage");
assertTest(isset($orders['funnel']['packed']['count']), "Funnel has 'packed' stage");
assertTest(isset($orders['funnel']['shipped']['count']), "Funnel has 'shipped' stage");
assertTest(isset($orders['funnel']['delivered']['count']), "Funnel has 'delivered' stage");
assertTest(isset($orders['funnel']['cancelled']['count']), "Funnel has 'cancelled' stage");
assertTest(isset($orders['funnel']['returned']['count']), "Funnel has 'returned' stage");
assertTest(isset($orders['payment_status']['paid']), "Payment status tracks 'paid' orders");
assertTest($orders['fulfillment_rate'] > 0, "Fulfillment rate % is calculated");

// --- 7. Revenue & P&L Statement Report ---
echo "\n--- Group 7: Revenue & P&L Statement Report ---\n";
$pnl = ReportManager::getRevenueReport('all');
assertTest(is_array($pnl), "Revenue report returns array");
assertTest($pnl['gross_revenue'] > 0, "P&L gross revenue is positive");
assertTest($pnl['total_cogs'] > 0, "P&L total COGS is calculated");
assertTest(is_array($pnl['cogs_items']) && count($pnl['cogs_items']) >= 6, "COGS includes at least 6 granular manufacturing cost items");
assertTest($pnl['gross_profit'] === round($pnl['gross_revenue'] - $pnl['total_cogs'], 2), "Gross profit equals Revenue minus COGS");
assertTest($pnl['operating_expenses'] > 0, "Operating expenses are calculated");
assertTest($pnl['net_profit'] === round($pnl['gross_profit'] - $pnl['operating_expenses'], 2), "Net profit equals Gross Profit minus Operating Expenses");
assertTest($pnl['gross_margin_pct'] >= 30.0, "Gross margin is at wholesale benchmark (>30%)");
assertTest($pnl['net_margin_pct'] >= 20.0, "Net margin is at wholesale benchmark (>20%)");

// --- 8. Product Sales Performance Report ---
echo "\n--- Group 8: Product Sales Performance Report ---\n";
$prods = ReportManager::getProductsPerformanceReport(20);
assertTest(is_array($prods) && !empty($prods), "Product performance returns list of products");
$p0 = $prods[0];
assertTest(isset($p0['title']) && !empty($p0['title']), "Product has title");
assertTest(isset($p0['sku']) && !empty($p0['sku']), "Product has SKU");
assertTest(isset($p0['category']), "Product has category");
assertTest(isset($p0['price']) && $p0['price'] > 0, "Product has selling price");
assertTest(isset($p0['cost_price']) && $p0['cost_price'] > 0, "Product has cost price");
assertTest(isset($p0['margin_pct']), "Product has margin %");
assertTest(isset($p0['units_sold']), "Product has units sold");
assertTest(isset($p0['total_gmv']), "Product has total GMV");
assertTest(in_array($p0['velocity'], ['Fast Mover', 'Medium', 'Slow Mover'], true), "Product has valid velocity badge");

// --- 9. Categories Report ---
echo "\n--- Group 9: Categories Report ---\n";
$cats = ReportManager::getCategoriesReport();
assertTest(is_array($cats), "Categories report returns array");
assertTest($cats['total_gmv'] > 0, "Category total GMV is positive");
assertTest(is_array($cats['categories']) && !empty($cats['categories']), "Categories array is populated");
$c0 = $cats['categories'][0];
assertTest(isset($c0['name']), "Category has name");
assertTest(isset($c0['products_count']), "Category has products count");
assertTest(isset($c0['units_sold']), "Category has units sold");
assertTest(isset($c0['gmv']) && $c0['gmv'] > 0, "Category has GMV");
assertTest(isset($c0['share_pct']) && $c0['share_pct'] > 0, "Category has share %");

// --- 10. Inventory Valuation & Stock Turn ---
echo "\n--- Group 10: Inventory Valuation & Stock Turn ---\n";
$inv = ReportManager::getInventoryReport();
assertTest(is_array($inv), "Inventory report returns array");
assertTest($inv['total_items'] > 0, "Inventory total items count is positive");
assertTest($inv['total_units'] > 0, "Inventory total units count is positive");
assertTest($inv['cost_valuation'] > 0, "Cost valuation is positive");
assertTest($inv['retail_valuation'] > $inv['cost_valuation'], "Retail valuation is strictly greater than wholesale cost valuation");
assertTest($inv['margin_potential_pct'] > 0, "Inventory margin potential % is positive");
assertTest($inv['in_stock_count'] > 0, "In stock items count is positive");
assertTest(is_array($inv['ledger']) && !empty($inv['ledger']), "Inventory ledger contains SKU rows");
$i0 = $inv['ledger'][0];
assertTest(isset($i0['sku']) && isset($i0['total_cost_value']) && isset($i0['total_retail_value']), "Ledger row has SKU, cost value, retail value");

// --- 11. Customers & Lifetime Value ---
echo "\n--- Group 11: Customers & Lifetime Value ---\n";
$cust = ReportManager::getCustomersReport('all');
assertTest(is_array($cust), "Customers report returns array");
assertTest($cust['total_customers'] > 0, "Total customers count is positive");
assertTest(is_array($cust['customers']) && !empty($cust['customers']), "Customers list is populated");
$cu0 = $cust['customers'][0];
assertTest(isset($cu0['name']) && isset($cu0['total_spent']), "Customer record has name and total spent");
assertTest(is_array($cust['state_distribution']) && !empty($cust['state_distribution']), "State geographic distribution is populated");

// Test role filter
$custRole = ReportManager::getCustomersReport('wholesaler');
assertTest(is_array($custRole), "Customer role filter query runs cleanly");

// --- 12. Role Distribution Report ---
echo "\n--- Group 12: Role Distribution Report ---\n";
$roles = ReportManager::getRoleDistributionReport();
assertTest(is_array($roles), "Role distribution report returns array");
assertTest($roles['total_revenue'] > 0, "Role distribution total revenue is positive");
assertTest(count($roles['roles']) === 5, "Role distribution contains EXACTLY the 5 official platform roles");
assertTest(isset($roles['roles']['guest']), "Role contains 'guest'");
assertTest(isset($roles['roles']['customer']), "Role contains 'customer'");
assertTest(isset($roles['roles']['retailer']), "Role contains 'retailer'");
assertTest(isset($roles['roles']['reseller']), "Role contains 'reseller'");
assertTest(isset($roles['roles']['wholesaler']), "Role contains 'wholesaler'");

// Test role specific deep dive
$rWholesale = ReportManager::getRoleSpecificReport('wholesaler');
assertTest(is_array($rWholesale) && $rWholesale['role'] === 'wholesaler', "Wholesaler deep dive returns correct role");
assertTest(is_array($rWholesale['buyers']), "Wholesaler deep dive includes buyers array");

$rRetailer = ReportManager::getRoleSpecificReport('retailer');
assertTest(is_array($rRetailer) && $rRetailer['role'] === 'retailer', "Retailer deep dive returns correct role");

$rReseller = ReportManager::getRoleSpecificReport('reseller');
assertTest(is_array($rReseller) && $rReseller['role'] === 'reseller', "Reseller deep dive returns correct role");

// --- 13. Payments & Gateway Reconciliation ---
echo "\n--- Group 13: Payments & Gateway Reconciliation ---\n";
$pay = ReportManager::getPaymentsReport('all');
assertTest(is_array($pay), "Payments report returns array");
assertTest($pay['total_collected'] > 0, "Total collected is positive");
assertTest($pay['total_transactions'] > 0, "Total transactions count is positive");
assertTest($pay['net_settlement'] > 0, "Net settlement amount is positive");
assertTest(isset($pay['gateways']['upi']), "Gateways includes Instant UPI");
assertTest(isset($pay['gateways']['razorpay']), "Gateways includes Razorpay");
assertTest(isset($pay['gateways']['cashfree']), "Gateways includes Cashfree");
assertTest(isset($pay['gateways']['cod']), "Gateways includes COD");
assertTest(isset($pay['gateways']['bank_transfer']), "Gateways includes Bank Transfer / Wire");

// --- 14. Shipping & Logistics SLA ---
echo "\n--- Group 14: Shipping & Logistics SLA ---\n";
$ship = ReportManager::getShippingReport('all');
assertTest(is_array($ship), "Shipping report returns array");
assertTest($ship['total_dispatched'] > 0, "Total dispatched parcels is positive");
assertTest(strpos($ship['origin_hub'], 'Surat') !== false, "Origin hub is Surat Depot");
assertTest(isset($ship['carriers']['delhivery']), "Carriers includes Delhivery Express");
assertTest(isset($ship['carriers']['bluedart']), "Carriers includes BlueDart Air Cargo");
assertTest(isset($ship['carriers']['tci']), "Carriers includes TCI Freight");
assertTest($ship['carriers']['delhivery']['success_rate'] > 0, "Delhivery delivery success rate is calculated");

// --- 15. Coupons & Discount Efficiency ---
echo "\n--- Group 15: Coupons & Discount Efficiency ---\n";
$coup = ReportManager::getCouponsReport();
assertTest(is_array($coup), "Coupons report returns array");
assertTest($coup['total_redemptions'] > 0, "Total redemptions count is positive");
assertTest($coup['total_discount_disbursed'] > 0, "Total discount disbursed is positive");
assertTest($coup['total_gmv_generated'] > 0, "Total GMV generated via coupons is positive");
assertTest(is_array($coup['coupons']) && !empty($coup['coupons']), "Coupons list is populated");
$cp0 = $coup['coupons'][0];
assertTest(isset($cp0['code']) && isset($cp0['roi_ratio']), "Coupon record has code and ROI ratio");

// --- 16. Returns & Refunds Report ---
echo "\n--- Group 16: Returns & Refunds Report ---\n";
$ret = ReportManager::getReturnsReport();
assertTest(is_array($ret), "Returns report returns array");
assertTest($ret['total_returns'] > 0, "Total return cases is positive");
assertTest($ret['total_refund_amount'] > 0, "Total refund amount is positive");
assertTest(isset($ret['reasons']['fabric_defect']), "Reasons tracks fabric defect");
assertTest(isset($ret['reasons']['size_misfit']), "Reasons tracks size misfit");
assertTest(isset($ret['reasons']['color_variation']), "Reasons tracks color variation");
assertTest(is_array($ret['records']) && !empty($ret['records']), "Returns records array is populated");
$rt0 = $ret['records'][0];
assertTest(isset($rt0['return_number']) && isset($rt0['order_number']), "Return record has return number and order number");

// --- 17. REST API Endpoints ---
echo "\n--- Group 17: REST API Endpoints ---\n";
$apiActions = [
    'stats', 'sales', 'orders', 'revenue', 'products', 'categories',
    'inventory', 'customers', 'roles', 'role_detail', 'payments',
    'shipping', 'coupons', 'returns'
];

foreach ($apiActions as $act) {
    $cmd = "php " . escapeshellarg(__DIR__ . '/run_api_action.php') . " GET " . escapeshellarg("api/reports.php?action=" . $act);
    $rawOut = shell_exec($cmd);
    $resp = json_decode($rawOut, true);
    assertTest(is_array($resp) && !empty($resp['success']), "REST API action '$act' returns success=true");
}

// Test Invalid API Action
$cmdInvalid = "php " . escapeshellarg(__DIR__ . '/run_api_action.php') . " GET " . escapeshellarg("api/reports.php?action=invalid_action_xyz");
$rawOut = shell_exec($cmdInvalid);
$resp = json_decode($rawOut, true);
assertTest(is_array($resp) && empty($resp['success']) && isset($resp['available_actions']), "REST API invalid action returns error and available_actions");

echo "\n========================================================================\n";
echo "  TEST SUMMARY: $passed PASSED, $failed FAILED (Total: $testNum)\n";
echo "========================================================================\n";

if ($failed > 0) {
    exit(1);
}
exit(0);
