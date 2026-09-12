<?php
declare(strict_types=1);

namespace DTBrand;

/**
 * UIComponent.php — Central Enterprise UI Component Library
 * DT Brand's & Jai Hanuman Tex — Section 39
 *
 * Provides standardized, reusable server-side rendering for all 24 canonical components:
 * 1. DataTable           7. ConfirmationDialog   13. MediaUploader      19. EmptyState
 * 2. SearchBox           8. Drawer               14. StatusBadge        20. LoadingSkeleton
 * 3. FilterBar           9. Tabs                 15. AuditTimeline      21. APIResponseViewer
 * 4. FilterDrawer       10. FormSection          16. ActivityFeed       22. JSONViewer
 * 5. Pagination         11. PriceMatrix          17. Toast              23. DateRangePicker
 * 6. Modal              12. VariantGrid          18. ErrorPanel         24. BulkActionBar
 *
 * Strict Compliance:
 * - 100% Real Vector SVG icons (stroke-width: 2.2), ZERO emojis
 * - Indian Rupee (₹) vector SVG for all pricing
 * - TailAdmin typography and high-contrast obsidian colors
 */

class UIComponent
{
    /**
     * Rupee vector SVG icon
     */
    public static function rupeeSvg(int $size = 14): string
    {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
    }

    /**
     * 1. DataTable Component
     * @param array<int,array<string,mixed>> $columns Column definitions: ['key' => 'id', 'label' => 'ID', 'sortable' => true]
     * @param array<int,array<string,mixed>> $rows Row data
     * @param array<string,mixed> $options ['id' => 'myTable', 'selectable' => true, 'actions' => true]
     */
    public static function dataTable(array $columns, array $rows, array $options = []): string
    {
        $id = htmlspecialchars($options['id'] ?? 'dt-table-' . bin2hex(random_bytes(4)));
        $selectable = $options['selectable'] ?? false;
        $class = htmlspecialchars($options['class'] ?? 'dt-component-table');

        $html = '<div class="dt-table-container" id="' . $id . '-wrap">';
        $html .= '<table class="' . $class . '" id="' . $id . '">';
        $html .= '<thead><tr>';

        if ($selectable) {
            $html .= '<th style="width:40px; text-align:center;"><input type="checkbox" class="dt-checkbox dt-select-all" data-target="' . $id . '"></th>';
        }

        foreach ($columns as $col) {
            $sortable = $col['sortable'] ?? false;
            $sortIcon = $sortable ? ' <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="vertical-align:middle;"><polyline points="6 9 12 15 18 9"></polyline></svg>' : '';
            $html .= '<th' . ($sortable ? ' class="dt-sortable" data-key="' . htmlspecialchars($col['key']) . '"' : '') . '>';
            $html .= htmlspecialchars($col['label']) . $sortIcon;
            $html .= '</th>';
        }

        $html .= '</tr></thead>';
        $html .= '<tbody>';

        if (empty($rows)) {
            $colSpan = count($columns) + ($selectable ? 1 : 0);
            $html .= '<tr><td colspan="' . $colSpan . '" style="text-align:center; padding:32px; color:#64748B;">No records found.</td></tr>';
        } else {
            foreach ($rows as $r) {
                $rowId = htmlspecialchars((string)($r['id'] ?? bin2hex(random_bytes(3))));
                $html .= '<tr data-id="' . $rowId . '">';
                if ($selectable) {
                    $html .= '<td style="text-align:center;"><input type="checkbox" class="dt-checkbox dt-row-select" value="' . $rowId . '"></td>';
                }
                foreach ($columns as $col) {
                    $k = $col['key'];
                    $val = $r[$k] ?? '';
                    $html .= '<td>' . ($col['raw'] ?? false ? $val : htmlspecialchars((string)$val)) . '</td>';
                }
                $html .= '</tr>';
            }
        }

        $html .= '</tbody></table></div>';
        return $html;
    }

    /**
     * 2. SearchBox Component
     */
    public static function searchBox(string $id, string $placeholder = 'Search records...', string $value = ''): string
    {
        return '
        <div class="dt-search-box-wrap" id="' . htmlspecialchars($id) . '-wrap">
            <svg class="dt-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="' . htmlspecialchars($id) . '" class="dt-search-input" placeholder="' . htmlspecialchars($placeholder) . '" value="' . htmlspecialchars($value) . '">
            <button type="button" class="dt-search-clear" onclick="document.getElementById(\'' . htmlspecialchars($id) . '\').value=\'\'; document.getElementById(\'' . htmlspecialchars($id) . '\').dispatchEvent(new Event(\'input\'));">&times;</button>
        </div>';
    }

    /**
     * 3. FilterBar Component
     * @param array<int,array<string,mixed>> $filters [['key' => 'status', 'label' => 'Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive']]]
     */
    public static function filterBar(array $filters, array $activeFilters = []): string
    {
        $html = '<div class="dt-filter-bar">';
        foreach ($filters as $f) {
            $key = htmlspecialchars($f['key']);
            $current = $activeFilters[$f['key']] ?? 'all';
            $html .= '<select class="dt-filter-select" name="' . $key . '" onchange="this.form ? this.form.submit() : null">';
            $html .= '<option value="all">' . htmlspecialchars($f['label']) . ': All</option>';
            foreach ($f['options'] as $val => $lbl) {
                $sel = ($current === (string)$val) ? ' selected' : '';
                $html .= '<option value="' . htmlspecialchars((string)$val) . '"' . $sel . '>' . htmlspecialchars($lbl) . '</option>';
            }
            $html .= '</select>';
        }
        $html .= '<button type="button" class="dt-btn-pale" style="font-size:0.75rem;" onclick="window.location.href=window.location.pathname">Reset Filters</button>';
        $html .= '</div>';
        return $html;
    }

    /**
     * 4. FilterDrawer Component (Slide-over drawer for advanced filtering)
     */
    public static function filterDrawer(string $id, string $title, string $contentHtml): string
    {
        return '
        <div class="dt-drawer-overlay" id="' . htmlspecialchars($id) . '">
            <div class="dt-drawer dt-drawer-right">
                <div class="dt-drawer-header">
                    <h3>' . htmlspecialchars($title) . '</h3>
                    <button class="dt-drawer-close" onclick="DTComponents.closeDrawer(\'' . htmlspecialchars($id) . '\')">&times;</button>
                </div>
                <div class="dt-drawer-body">' . $contentHtml . '</div>
                <div class="dt-drawer-footer">
                    <button type="button" class="dt-btn-pale" onclick="DTComponents.closeDrawer(\'' . htmlspecialchars($id) . '\')">Cancel</button>
                    <button type="submit" class="dt-btn-gold">Apply Filters</button>
                </div>
            </div>
        </div>';
    }

    /**
     * 5. Pagination Component
     */
    public static function pagination(int $currentPage, int $totalPages, int $totalItems, int $limit = 25): string
    {
        $startItem = max(1, ($currentPage - 1) * $limit + 1);
        $endItem = min($totalItems, $currentPage * $limit);

        $html = '<div class="dt-pagination-wrap">';
        $html .= '<div class="dt-pagination-info">Showing <strong>' . $startItem . '-' . $endItem . '</strong> of <strong>' . $totalItems . '</strong> records</div>';
        $html .= '<div class="dt-pagination-pages">';

        if ($currentPage > 1) {
            $html .= '<a href="?page=' . ($currentPage - 1) . '" class="dt-page-btn">&laquo; Prev</a>';
        }

        for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++) {
            $activeClass = ($i === $currentPage) ? ' active' : '';
            $html .= '<a href="?page=' . $i . '" class="dt-page-btn' . $activeClass . '">' . $i . '</a>';
        }

        if ($currentPage < $totalPages) {
            $html .= '<a href="?page=' . ($currentPage + 1) . '" class="dt-page-btn">Next &raquo;</a>';
        }

        $html .= '</div></div>';
        return $html;
    }

    /**
     * 6. Modal Component
     */
    public static function modal(string $id, string $title, string $bodyHtml, string $footerHtml = ''): string
    {
        return '
        <div class="dt-modal-overlay" id="' . htmlspecialchars($id) . '">
            <div class="dt-modal">
                <div class="dt-modal-header">
                    <h3>' . htmlspecialchars($title) . '</h3>
                    <button class="dt-modal-close" onclick="DTComponents.closeModal(\'' . htmlspecialchars($id) . '\')">&times;</button>
                </div>
                <div class="dt-modal-body">' . $bodyHtml . '</div>
                ' . ($footerHtml ? '<div class="dt-modal-footer">' . $footerHtml . '</div>' : '') . '
            </div>
        </div>';
    }

    /**
     * 7. ConfirmationDialog Component (with optional typed confirmation phrase)
     */
    public static function confirmationDialog(string $id, string $title, string $message, string $actionBtn = 'Confirm', ?string $typedPhrase = null): string
    {
        $phraseHtml = '';
        if ($typedPhrase !== null) {
            $phraseHtml = '
            <div style="margin-top:14px;">
                <label style="display:block; font-size:0.78rem; font-weight:700; color:#DC2626; margin-bottom:6px;">
                    Type <strong>' . htmlspecialchars($typedPhrase) . '</strong> to confirm:
                </label>
                <input type="text" id="' . htmlspecialchars($id) . '-phrase-input" class="dt-input" placeholder="' . htmlspecialchars($typedPhrase) . '" oninput="document.getElementById(\'' . htmlspecialchars($id) . '-confirm-btn\').disabled = (this.value !== \'' . htmlspecialchars($typedPhrase) . '\');">
            </div>';
        }

        $footer = '
        <button type="button" class="dt-btn-pale" onclick="DTComponents.closeModal(\'' . htmlspecialchars($id) . '\')">Cancel</button>
        <button type="button" id="' . htmlspecialchars($id) . '-confirm-btn" class="dt-btn-gold" style="background:linear-gradient(135deg, #DC2626 0%, #B91C1C 100%); color:#FFFFFF; border-color:#991B1B;" ' . ($typedPhrase !== null ? 'disabled' : '') . '>' . htmlspecialchars($actionBtn) . '</button>';

        return self::modal($id, $title, '<p style="margin:0; font-size:0.88rem; color:#1F2937;">' . htmlspecialchars($message) . '</p>' . $phraseHtml, $footer);
    }

    /**
     * 8. Drawer Component (Left or Right Slide-in)
     */
    public static function drawer(string $id, string $title, string $bodyHtml, string $side = 'right'): string
    {
        $sideClass = $side === 'left' ? 'dt-drawer-left' : 'dt-drawer-right';
        return '
        <div class="dt-drawer-overlay" id="' . htmlspecialchars($id) . '">
            <div class="dt-drawer ' . $sideClass . '">
                <div class="dt-drawer-header">
                    <h3>' . htmlspecialchars($title) . '</h3>
                    <button class="dt-drawer-close" onclick="DTComponents.closeDrawer(\'' . htmlspecialchars($id) . '\')">&times;</button>
                </div>
                <div class="dt-drawer-body">' . $bodyHtml . '</div>
            </div>
        </div>';
    }

    /**
     * 9. Tabs Component
     * @param array<int,array<string,string>> $tabs [['id' => 'general', 'label' => 'General Settings'], ['id' => 'pricing', 'label' => 'Price Rules']]
     */
    public static function tabs(array $tabs, string $activeTabId): string
    {
        $html = '<div class="dt-tabs-nav">';
        foreach ($tabs as $tab) {
            $id = htmlspecialchars($tab['id']);
            $isActive = ($tab['id'] === $activeTabId) ? ' active' : '';
            $html .= '<button type="button" class="dt-tab-btn' . $isActive . '" data-target="' . $id . '" onclick="DTComponents.switchTab(this, \'' . $id . '\')">';
            $html .= htmlspecialchars($tab['label']);
            $html .= '</button>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * 10. FormSection Component
     */
    public static function formSection(string $title, string $desc, string $fieldsHtml): string
    {
        return '
        <div class="dt-form-section">
            <div class="dt-form-section-head">
                <h4>' . htmlspecialchars($title) . '</h4>
                <p>' . htmlspecialchars($desc) . '</p>
            </div>
            <div class="dt-form-section-body">' . $fieldsHtml . '</div>
        </div>';
    }

    /**
     * 11. PriceMatrix Component (Multi-Tier B2B Wholesale Pricing)
     */
    public static function priceMatrix(array $pricingData): string
    {
        $html = '<div class="dt-price-matrix-wrap">';
        $html .= '<table class="dt-price-matrix-table">';
        $html .= '<thead><tr>
            <th>Tier Level</th>
            <th>MOQ Rule</th>
            <th>Selling Price (INR)</th>
            <th>Margin / Discount</th>
        </tr></thead><tbody>';

        if (!empty($pricingData) && isset($pricingData[0]) && is_array($pricingData[0])) {
            // Custom tier list passed in
            foreach ($pricingData as $t) {
                $name = htmlspecialchars((string)($t['tier'] ?? $t['name'] ?? 'Tier'));
                $moq = htmlspecialchars((string)($t['moq'] ?? '1 Pc'));
                $price = (float)($t['wholesale_price'] ?? $t['price'] ?? 0.0);
                $desc = htmlspecialchars((string)($t['margin'] ?? $t['desc'] ?? ''));
                $cls = htmlspecialchars((string)($t['cls'] ?? ''));

                $html .= '<tr class="' . $cls . '">';
                $html .= '<td><strong>' . $name . '</strong></td>';
                $html .= '<td><span class="dt-badge-pale">' . $moq . '</span></td>';
                $html .= '<td><span style="font-weight:800; font-size:0.95rem; color:#111827;">' . self::rupeeSvg(13) . ' ' . number_format($price, 2) . '</span></td>';
                $html .= '<td><span style="font-size:0.8rem; color:#15803D; font-weight:700;">' . $desc . '</span></td>';
                $html .= '</tr>';
            }
        } else {
            // Default 5-tier dictionary
            $mrp = (float)($pricingData['mrp'] ?? 4999.00);
            $retail = (float)($pricingData['retail_price'] ?? 3499.00);
            $reseller = (float)($pricingData['reseller_price'] ?? 2899.00);
            $wholesaleMoq4 = (float)($pricingData['wholesale_moq4_price'] ?? 2450.00);
            $wholesaleMoq8 = (float)($pricingData['wholesale_moq8_price'] ?? 2199.00);

            $tiers = [
                ['name' => 'MRP (Label Price)', 'moq' => '1 Pc', 'price' => $mrp, 'desc' => 'Maximum Retail Price', 'cls' => ''],
                ['name' => 'Standard Retail', 'moq' => '1 Pc', 'price' => $retail, 'desc' => round((($mrp - $retail)/max(1.0, $mrp))*100, 1) . '% OFF MRP', 'cls' => ''],
                ['name' => 'Reseller Hub', 'moq' => '1 Pc', 'price' => $reseller, 'desc' => round((($retail - $reseller)/max(1.0, $retail))*100, 1) . '% Margin', 'cls' => 'highlight-reseller'],
                ['name' => 'Wholesale Half Set', 'moq' => 'Min 4 Pcs', 'price' => $wholesaleMoq4, 'desc' => 'B2B Wholesale Tier 1', 'cls' => 'highlight-wholesale'],
                ['name' => 'Wholesale Full Set', 'moq' => 'Min 8 Pcs', 'price' => $wholesaleMoq8, 'desc' => 'Master Lot Tier', 'cls' => 'highlight-wholesale']
            ];

            foreach ($tiers as $t) {
                $html .= '<tr class="' . $t['cls'] . '">';
                $html .= '<td><strong>' . htmlspecialchars($t['name']) . '</strong></td>';
                $html .= '<td><span class="dt-badge-pale">' . htmlspecialchars($t['moq']) . '</span></td>';
                $html .= '<td><span style="font-weight:800; font-size:0.95rem; color:#111827;">' . self::rupeeSvg(13) . ' ' . number_format($t['price'], 2) . '</span></td>';
                $html .= '<td><span style="font-size:0.8rem; color:#15803D; font-weight:700;">' . htmlspecialchars($t['desc']) . '</span></td>';
                $html .= '</tr>';
            }
        }

        $html .= '</tbody></table></div>';
        return $html;
    }

    /**
     * 12. VariantGrid Component
     */
    public static function variantGrid(array $variants): string
    {
        $hasPrice = false;
        foreach ($variants as $v) {
            if (isset($v['price']) || isset($v['wholesale_price'])) {
                $hasPrice = true;
                break;
            }
        }

        $html = '<div class="dt-table-container">';
        $html .= '<table class="dt-component-table"><thead><tr>
            <th>Color / Shade</th>
            <th>Size / Cut</th>
            <th>SKU Code</th>
            <th>In Stock Qty</th>' .
            ($hasPrice ? '<th>Wholesale Rate</th>' : '') . '
            <th>Status</th>
        </tr></thead><tbody>';

        foreach ($variants as $v) {
            $qty = (int)($v['stock_qty'] ?? $v['stock'] ?? 0);
            $statusBadge = $qty > 10 ? self::statusBadge('active', $qty . ' in stock') : ($qty > 0 ? self::statusBadge('warning', 'Low (' . $qty . ')') : self::statusBadge('danger', 'Out of Stock'));

            $html .= '<tr>';
            $html .= '<td><strong>' . htmlspecialchars($v['color'] ?? 'Standard') . '</strong></td>';
            $html .= '<td>' . htmlspecialchars($v['size'] ?? 'Free Size') . '</td>';
            $html .= '<td><code>' . htmlspecialchars($v['sku'] ?? 'SKU-001') . '</code></td>';
            $html .= '<td><strong>' . $qty . ' Pcs</strong></td>';
            if ($hasPrice) {
                $pr = (float)($v['wholesale_price'] ?? $v['price'] ?? 0.0);
                $html .= '<td><span style="font-weight:700; color:#111827; display:inline-flex; align-items:center; gap:2px;">' . self::rupeeSvg(13) . ' ' . number_format($pr, 2) . '</span></td>';
            }
            $html .= '<td>' . $statusBadge . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table></div>';
        return $html;
    }

    /**
     * 13. MediaUploader Component (Drag & drop zone)
     */
    public static function mediaUploader(string $id, array $options = []): string
    {
        $accept = htmlspecialchars($options['accept'] ?? 'image/jpeg,image/png,image/webp');
        $maxSize = htmlspecialchars($options['max_size'] ?? '10MB');
        $maxFiles = (int)($options['maxFiles'] ?? $options['max_files'] ?? 10);

        return '
        <div class="dt-media-uploader dt-media-dropzone" id="' . htmlspecialchars($id) . '-zone" onclick="document.getElementById(\'' . htmlspecialchars($id) . '-file\').click();" data-max-files="' . $maxFiles . '">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            <div style="font-weight:700; color:#111827; margin-top:8px; font-size:0.92rem;">Drag &amp; drop product media here or <span style="color:#8A681F; text-decoration:underline;">Browse</span></div>
            <div style="font-size:0.75rem; color:#64748B; margin-top:4px;">Supported formats: JPEG, PNG, WebP (Max ' . $maxSize . ', up to ' . $maxFiles . ' files)</div>
            <input type="file" id="' . htmlspecialchars($id) . '-file" accept="' . $accept . '" multiple style="display:none;" onchange="DTComponents.handleFileSelect ? DTComponents.handleFileSelect(this, \'' . htmlspecialchars($id) . '\') : null;">
            <div class="dt-media-previews dt-uploader-preview" id="' . htmlspecialchars($id) . '-preview" style="display:none; margin-top:14px;"></div>
        </div>';
    }

    /**
     * 14. StatusBadge Component
     */
    public static function statusBadge(string $status, ?string $label = null): string
    {
        $st = strtolower(trim($status));
        $lbl = $label ?? ucfirst($st);

        $badgeMap = [
            'active' => 'dt-badge-success',
            'approved' => 'dt-badge-success',
            'completed' => 'dt-badge-success',
            'paid' => 'dt-badge-success',
            'pending' => 'dt-badge-warning',
            'processing' => 'dt-badge-warning',
            'inactive' => 'dt-badge-pale',
            'draft' => 'dt-badge-pale',
            'failed' => 'dt-badge-danger',
            'cancelled' => 'dt-badge-danger',
            'rejected' => 'dt-badge-danger',
            'danger' => 'dt-badge-danger'
        ];

        $class = $badgeMap[$st] ?? 'dt-badge-info';

        return '<span class="dt-badge ' . $class . '">' . htmlspecialchars($lbl) . '</span>';
    }

    /**
     * 15. AuditTimeline Component
     * @param array<int,array<string,mixed>> $events [['action' => 'Price Update', 'actor' => 'Admin (ID 1)', 'time' => '10 mins ago', 'desc' => 'Changed margin discount']]
     */
    public static function auditTimeline(array $events): string
    {
        $html = '<div class="dt-timeline">';
        foreach ($events as $ev) {
            $title = htmlspecialchars((string)($ev['title'] ?? $ev['action'] ?? 'Event'));
            $time = htmlspecialchars((string)($ev['time'] ?? $ev['timestamp'] ?? ''));
            $desc = htmlspecialchars((string)($ev['desc'] ?? ''));
            $actor = !empty($ev['actor']) ? htmlspecialchars((string)$ev['actor']) : '';

            $html .= '<div class="dt-timeline-item">';
            $html .= '<div class="dt-timeline-dot"></div>';
            $html .= '<div class="dt-timeline-content">';
            $html .= '<div style="display:flex; justify-content:space-between; align-items:center;">
                <strong>' . $title . '</strong>
                <span style="font-size:0.75rem; color:#64748B;">' . $time . '</span>
            </div>';
            if ($desc !== '') {
                $html .= '<div style="font-size:0.78rem; color:#4B5563; margin-top:3px;">' . $desc . '</div>';
            }
            if ($actor !== '') {
                $html .= '<div style="font-size:0.72rem; color:#8A681F; margin-top:2px;">By ' . $actor . '</div>';
            }
            $html .= '</div></div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * 16. ActivityFeed Component
     */
    public static function activityFeed(array $activities): string
    {
        $html = '<div class="dt-activity-feed">';
        foreach ($activities as $act) {
            $title = (string)($act['title'] ?? (!empty($act['user']) ? $act['user'] . ' ' . ($act['action'] ?? '') : ($act['action'] ?? 'Activity')));
            $time = (string)($act['timestamp'] ?? $act['time'] ?? 'Just now');
            $sub = (string)($act['subtitle'] ?? $act['desc'] ?? '');

            $html .= '<div class="dt-activity-item">';
            $html .= '<div class="dt-activity-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>';
            $html .= '<div class="dt-activity-text">';
            $html .= '<div style="font-weight:700; color:#111827; font-size:0.85rem;">' . htmlspecialchars($title) . '</div>';
            $html .= '<div style="font-size:0.76rem; color:#64748B;">' . htmlspecialchars($time) . ($sub !== '' ? ' &bull; ' . htmlspecialchars($sub) : '') . '</div>';
            $html .= '</div></div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * 17. Toast Container
     */
    public static function toastContainer(): string
    {
        return '<div id="dtToastContainer" class="dt-toast-container"></div>';
    }

    /**
     * 18. ErrorPanel Component
     */
    public static function errorPanel(string $title, string $message, ?string $actionUrl = null): string
    {
        $actionHtml = $actionUrl ? '<a href="' . htmlspecialchars($actionUrl) . '" class="dt-btn-pale" style="margin-top:10px; font-size:0.75rem;">Retry Action</a>' : '';
        return '
        <div class="dt-error-panel">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2" style="flex-shrink:0;">
                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <div>
                <strong style="color:#991B1B; font-size:0.92rem;">' . htmlspecialchars($title) . '</strong>
                <p style="margin:4px 0 0 0; font-size:0.82rem; color:#B91C1C;">' . htmlspecialchars($message) . '</p>
                ' . $actionHtml . '
            </div>
        </div>';
    }

    /**
     * 19. EmptyState Component
     */
    public static function emptyState(string $title, string $desc, ?string $ctaText = null, ?string $ctaUrl = null): string
    {
        $cta = ($ctaText && $ctaUrl) ? '<a href="' . htmlspecialchars($ctaUrl) . '" class="dt-btn-gold" style="margin-top:16px;">' . htmlspecialchars($ctaText) . '</a>' : '';
        return '
        <div class="dt-empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="1.8">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
            </svg>
            <h3 style="margin:12px 0 6px 0; font-size:1.15rem; color:#111827; font-weight:800;">' . htmlspecialchars($title) . '</h3>
            <p style="margin:0; font-size:0.84rem; color:#64748B; max-width:420px;">' . htmlspecialchars($desc) . '</p>
            ' . $cta . '
        </div>';
    }

    /**
     * 20. LoadingSkeleton Component
     */
    public static function loadingSkeleton(string $type = 'table', int $count = 4): string
    {
        $html = '<div class="dt-skeleton-wrap">';
        if ($type === 'table') {
            for ($i = 0; $i < $count; $i++) {
                $html .= '<div class="dt-skeleton-row">
                    <div class="dt-skeleton-box" style="width:25%;"></div>
                    <div class="dt-skeleton-box" style="width:40%;"></div>
                    <div class="dt-skeleton-box" style="width:20%;"></div>
                    <div class="dt-skeleton-box" style="width:15%;"></div>
                </div>';
            }
        } elseif ($type === 'card') {
            for ($i = 0; $i < $count; $i++) {
                $html .= '<div class="dt-skeleton-card">
                    <div class="dt-skeleton-box" style="width:40%; height:14px; margin-bottom:10px;"></div>
                    <div class="dt-skeleton-box" style="width:80%; height:24px; margin-bottom:8px;"></div>
                    <div class="dt-skeleton-box" style="width:50%; height:12px;"></div>
                </div>';
            }
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * 21. APIResponseViewer Component
     */
    public static function apiResponseViewer(mixed $data, string $title = 'API Response'): string
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        return '
        <div class="dt-terminal-card">
            <div class="dt-terminal-card-head">
                <div class="dt-terminal-dots">
                    <span class="dot-red"></span>
                    <span class="dot-yellow"></span>
                    <span class="dot-green"></span>
                </div>
                <span>' . htmlspecialchars($title) . '</span>
                <button type="button" class="dt-btn-pale" style="padding:2px 8px; font-size:0.7rem;" onclick="navigator.clipboard.writeText(this.closest(\'.dt-terminal-card\').querySelector(\'pre\').textContent); DTComponents.toast(\'Copied JSON response\', \'success\');">Copy</button>
            </div>
            <pre class="dt-terminal-pre">' . htmlspecialchars((string)$json) . '</pre>
        </div>';
    }

    /**
     * 22. JSONViewer Component
     */
    public static function jsonViewer(mixed $data): string
    {
        return self::apiResponseViewer($data, 'JSON Spec Viewer');
    }

    /**
     * 23. DateRangePicker Component
     */
    public static function dateRangePicker(string $id, string $selected = '30days'): string
    {
        $presets = [
            'today' => 'Today',
            'yesterday' => 'Yesterday',
            '7days' => 'Last 7 Days',
            '30days' => 'Last 30 Days',
            'month' => 'This Month',
            'custom' => 'Custom'
        ];

        $html = '<div class="dt-daterange-wrap" id="' . htmlspecialchars($id) . '">';
        foreach ($presets as $val => $lbl) {
            $act = ($val === $selected) ? ' active' : '';
            $html .= '<button type="button" class="dt-date-pill' . $act . '" data-range="' . $val . '" onclick="DTComponents.selectDateRange(this, \'' . $val . '\')">' . $lbl . '</button>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * 24. BulkActionBar Component
     */
    public static function bulkActionBar(string $tableId, array $actions): string
    {
        $html = '
        <div class="dt-bulk-bar" id="' . htmlspecialchars($tableId) . '-bulk-bar" style="display:none;">
            <div class="dt-bulk-bar-info">
                <span id="' . htmlspecialchars($tableId) . '-selected-count">0</span> items selected
            </div>
            <div class="dt-bulk-bar-actions">';

        foreach ($actions as $act) {
            $html .= '<button type="button" class="dt-btn-pale" style="font-size:0.75rem;" onclick="' . htmlspecialchars($act['callback']) . '(\'' . htmlspecialchars($tableId) . '\')">';
            $html .= htmlspecialchars($act['label']);
            $html .= '</button>';
        }

        $html .= '
                <button type="button" class="dt-btn-pale" style="border-color:#DC2626; color:#DC2626; font-size:0.75rem;" onclick="DTComponents.clearSelection(\'' . htmlspecialchars($tableId) . '\')">Deselect All</button>
            </div>
        </div>';
        return $html;
    }
}
