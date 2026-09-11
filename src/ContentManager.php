<?php
namespace DTBrand;

use PDO;
use Exception;

/**
 * ContentManager — Central Marketing, Homepage Curation & Content Engine
 * Section 29 (Marketing / Content Admin)
 * DT Brand's & Jai Hanuman Tex
 */
class ContentManager
{
    private static array $mockBanners = [];
    private static array $mockSections = [];
    private static array $mockCollections = [];
    private static array $mockCuratedLists = [];
    private static array $mockAnnouncements = [];
    private static array $mockSeo = [];
    private static array $mockTemplates = [];
    private static array $mockSocial = [];

    // ─────────────────────────────────────────────────────────────
    // 1. BANNERS & HERO SLIDERS
    // ─────────────────────────────────────────────────────────────

    /**
     * Polymorphic banner retrieval accepting ($type, $onlyActive) or ($onlyActive, $placement).
     */
    public static function getBanners($param1 = null, $param2 = null): array
    {
        $type = null;
        $onlyActive = true;

        if (is_bool($param1)) {
            $onlyActive = $param1;
            if (is_string($param2) && $param2 !== '') {
                $type = $param2;
            }
        } elseif (is_string($param1) && $param1 !== '') {
            $type = $param1;
            if (is_bool($param2)) {
                $onlyActive = $param2;
            }
        } elseif (is_bool($param2)) {
            $onlyActive = $param2;
        }

        // Normalize placement names (hero -> hero_slider, promo_strip -> promo_banner)
        $mappedType = $type;
        if ($type === 'hero') $mappedType = 'hero_slider';
        if ($type === 'promo_strip') $mappedType = 'promo_banner';

        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return self::getFallbackBanners($mappedType, $onlyActive);
        }

        try {
            $where = [];
            $params = [];

            if ($onlyActive) {
                $where[] = "`status` = 'active'";
            }
            if (!empty($mappedType)) {
                $where[] = "(`banner_type` = :type OR `placement` = :type)";
                $params[':type'] = $mappedType;
            }

            $whereSql = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
            $stmt = $db->prepare("SELECT * FROM `banners` {$whereSql} ORDER BY `display_order` ASC, `id` DESC");
            $stmt->execute($params);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return !empty($rows) ? $rows : self::getFallbackBanners($mappedType, $onlyActive);
        } catch (\Throwable $e) {
            error_log("ContentManager::getBanners error: " . $e->getMessage());
            return self::getFallbackBanners($mappedType, $onlyActive);
        }
    }

    public static function getHeroSliders(bool $onlyActive = true): array
    {
        return self::getBanners('hero_slider', $onlyActive);
    }

    public static function saveBanner(array $data): int
    {
        $db = Database::getConnection();
        $id = (int)($data['id'] ?? 0);
        $type = $data['placement'] ?? $data['banner_type'] ?? 'hero_slider';
        if ($type === 'hero') $type = 'hero_slider';
        if ($type === 'promo_strip') $type = 'promo_banner';

        $title = trim((string)($data['title'] ?? ''));
        $subtitle = trim((string)($data['subtitle'] ?? ''));
        $tagline = trim((string)($data['tagline'] ?? $subtitle));
        $badge = trim((string)($data['badge_text'] ?? $data['badge'] ?? ''));
        $image = trim((string)($data['image_url'] ?? $data['image'] ?? ''));
        $imageMobile = trim((string)($data['image_mobile_url'] ?? $data['image_mobile'] ?? ''));
        $bgColor = trim((string)($data['bg_color'] ?? '#181512'));
        $ctaText = trim((string)($data['button_text'] ?? $data['cta_text'] ?? 'Explore Now'));
        $ctaUrl = trim((string)($data['link_url'] ?? $data['cta_url'] ?? '/shop.php'));
        $status = in_array($data['status'] ?? '', ['active', 'inactive'], true) ? $data['status'] : 'active';
        $order = (int)($data['display_order'] ?? 1);

        if ($db === null || Database::isMockMode()) {
            $newId = $id > 0 ? $id : (count(self::$mockBanners) + 1);
            $normalized = [
                'id' => $newId,
                'banner_type' => $type,
                'placement' => $type,
                'title' => $title,
                'subtitle' => $subtitle,
                'tagline' => $tagline,
                'badge' => $badge,
                'badge_text' => $badge,
                'image' => $image,
                'image_url' => $image,
                'image_mobile' => $imageMobile,
                'image_mobile_url' => $imageMobile,
                'bg_color' => $bgColor,
                'cta_text' => $ctaText,
                'button_text' => $ctaText,
                'cta_url' => $ctaUrl,
                'link_url' => $ctaUrl,
                'status' => $status,
                'display_order' => $order
            ];
            self::$mockBanners[$newId] = $normalized;
            return $newId;
        }

        try {
            if ($id > 0) {
                $stmt = $db->prepare("
                    UPDATE `banners` SET
                        `banner_type` = :type,
                        `title` = :title,
                        `subtitle` = :subtitle,
                        `tagline` = :tagline,
                        `badge` = :badge,
                        `image` = :image,
                        `image_mobile` = :image_mobile,
                        `bg_color` = :bg_color,
                        `cta_text` = :cta_text,
                        `cta_url` = :cta_url,
                        `status` = :status,
                        `display_order` = :order,
                        `updated_at` = NOW()
                    WHERE `id` = :id
                ");
                $stmt->execute([
                    ':type' => $type, ':title' => $title, ':subtitle' => $subtitle,
                    ':tagline' => $tagline, ':badge' => $badge, ':image' => $image,
                    ':image_mobile' => $imageMobile, ':bg_color' => $bgColor,
                    ':cta_text' => $ctaText, ':cta_url' => $ctaUrl, ':status' => $status,
                    ':order' => $order, ':id' => $id
                ]);
                return $id;
            } else {
                $stmt = $db->prepare("
                    INSERT INTO `banners` (
                        `banner_type`, `title`, `subtitle`, `tagline`, `badge`,
                        `image`, `image_mobile`, `bg_color`, `cta_text`, `cta_url`,
                        `status`, `display_order`, `created_at`
                    ) VALUES (
                        :type, :title, :subtitle, :tagline, :badge,
                        :image, :image_mobile, :bg_color, :cta_text, :cta_url,
                        :status, :order, NOW()
                    )
                ");
                $stmt->execute([
                    ':type' => $type, ':title' => $title, ':subtitle' => $subtitle,
                    ':tagline' => $tagline, ':badge' => $badge, ':image' => $image,
                    ':image_mobile' => $imageMobile, ':bg_color' => $bgColor,
                    ':cta_text' => $ctaText, ':cta_url' => $ctaUrl, ':status' => $status,
                    ':order' => $order
                ]);
                return (int)$db->lastInsertId();
            }
        } catch (\Throwable $e) {
            error_log("ContentManager::saveBanner error: " . $e->getMessage());
            return 0;
        }
    }

    public static function createBanner(array $data): int
    {
        return self::saveBanner($data);
    }

    public static function updateBanner(int $id, array $data): bool
    {
        $data['id'] = $id;
        return self::saveBanner($data) > 0;
    }

    public static function deleteBanner(int $id): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            unset(self::$mockBanners[$id]);
            return true;
        }

        try {
            $stmt = $db->prepare("DELETE FROM `banners` WHERE `id` = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // 2. HOMEPAGE SECTIONS
    // ─────────────────────────────────────────────────────────────

    public static function getHomepageSections(bool $onlyActive = true): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $sections = !empty(self::$mockSections) ? array_values(self::$mockSections) : self::getFallbackHomepageSections($onlyActive);
            if ($onlyActive) {
                $sections = array_filter($sections, fn($s) => (int)($s['is_active'] ?? 1) === 1);
            }
            usort($sections, fn($a, $b) => ((int)($a['display_order'] ?? 0)) <=> ((int)($b['display_order'] ?? 0)));
            return array_values($sections);
        }

        try {
            $sql = "SELECT * FROM `homepage_sections` " . ($onlyActive ? "WHERE `is_active` = 1 " : "") . "ORDER BY `display_order` ASC";
            $stmt = $db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($rows) ? $rows : self::getFallbackHomepageSections($onlyActive);
        } catch (\Throwable $e) {
            return self::getFallbackHomepageSections($onlyActive);
        }
    }

    public static function saveHomepageSection(string $sectionKey, array $data): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $id = (int)($data['id'] ?? (count(self::$mockSections) + 1));
            self::$mockSections[$sectionKey] = array_merge($data, ['id' => $id, 'section_key' => $sectionKey]);
            return true;
        }

        try {
            $title = $data['title'] ?? 'Section';
            $subtitle = $data['subtitle'] ?? '';
            $type = $data['section_type'] ?? 'product_grid';
            $order = (int)($data['display_order'] ?? 1);
            $active = isset($data['is_active']) ? (int)$data['is_active'] : 1;
            $cfg = json_encode($data['config'] ?? []);

            $stmt = $db->prepare("
                INSERT INTO `homepage_sections` (`section_key`, `title`, `subtitle`, `section_type`, `display_order`, `is_active`, `config_json`, `updated_at`)
                VALUES (:k, :t, :sub, :type, :ord, :act, :cfg, NOW())
                ON DUPLICATE KEY UPDATE
                    `title` = VALUES(`title`),
                    `subtitle` = VALUES(`subtitle`),
                    `section_type` = VALUES(`section_type`),
                    `display_order` = VALUES(`display_order`),
                    `is_active` = VALUES(`is_active`),
                    `config_json` = VALUES(`config_json`),
                    `updated_at` = NOW()
            ");
            return $stmt->execute([
                ':k' => $sectionKey, ':t' => $title, ':sub' => $subtitle,
                ':type' => $type, ':ord' => $order, ':act' => $active, ':cfg' => $cfg
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function createHomepageSection(array $data): int
    {
        $key = trim((string)($data['section_key'] ?? 'section_' . time()));
        $ok = self::saveHomepageSection($key, $data);
        return $ok ? 1 : 0;
    }

    public static function updateHomepageSection(int $id, array $data): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            foreach (self::$mockSections as $k => $sec) {
                if ((int)($sec['id'] ?? 0) === $id) {
                    self::$mockSections[$k] = array_merge($sec, $data);
                    return true;
                }
            }
            return true;
        }

        try {
            $fields = [];
            $params = [':id' => $id];
            if (isset($data['title'])) { $fields[] = "`title` = :t"; $params[':t'] = $data['title']; }
            if (isset($data['subtitle'])) { $fields[] = "`subtitle` = :s"; $params[':s'] = $data['subtitle']; }
            if (isset($data['display_order'])) { $fields[] = "`display_order` = :ord"; $params[':ord'] = (int)$data['display_order']; }
            if (isset($data['is_active'])) { $fields[] = "`is_active` = :act"; $params[':act'] = (int)$data['is_active']; }

            if (empty($fields)) return true;
            $sql = "UPDATE `homepage_sections` SET " . implode(", ", $fields) . ", `updated_at` = NOW() WHERE `id` = :id";
            $stmt = $db->prepare($sql);
            return $stmt->execute($params);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function reorderHomepageSections(array $orderMap): bool
    {
        foreach ($orderMap as $id => $order) {
            self::updateHomepageSection((int)$id, ['display_order' => (int)$order]);
        }
        return true;
    }

    // ─────────────────────────────────────────────────────────────
    // 3. CURATED COLLECTIONS
    // ─────────────────────────────────────────────────────────────

    public static function getCuratedCollections(bool $onlyActive = true): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $cols = !empty(self::$mockCollections) ? array_values(self::$mockCollections) : self::getFallbackCollections($onlyActive);
            if ($onlyActive) {
                $cols = array_filter($cols, fn($c) => ($c['status'] ?? 'active') === 'active' || (int)($c['is_active'] ?? 1) === 1);
            }
            return array_values($cols);
        }

        try {
            $sql = "SELECT * FROM `curated_collections` " . ($onlyActive ? "WHERE `is_active` = 1 " : "") . "ORDER BY `display_order` ASC";
            $stmt = $db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($rows) ? $rows : self::getFallbackCollections($onlyActive);
        } catch (\Throwable $e) {
            return self::getFallbackCollections($onlyActive);
        }
    }

    public static function getCuratedCollectionBySlug(string $slug): ?array
    {
        $all = self::getCuratedCollections(false);
        foreach ($all as $col) {
            if (($col['slug'] ?? '') === $slug) {
                return $col;
            }
        }
        return null;
    }

    public static function saveCuratedCollection(array $data): int
    {
        $db = Database::getConnection();
        $id = (int)($data['id'] ?? 0);
        $title = trim((string)($data['title'] ?? ''));
        $slug = trim((string)($data['slug'] ?? strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title))));
        $tagline = trim((string)($data['tagline'] ?? $data['description'] ?? ''));
        $image = trim((string)($data['image_url'] ?? ''));
        $badge = trim((string)($data['badge'] ?? ''));
        $order = (int)($data['display_order'] ?? 1);
        $active = isset($data['is_active']) ? (int)$data['is_active'] : (($data['status'] ?? 'active') === 'active' ? 1 : 0);
        $itemCount = (int)($data['item_count'] ?? 0);
        $productIds = is_array($data['product_ids'] ?? null) ? json_encode($data['product_ids']) : '[]';

        if ($db === null || Database::isMockMode()) {
            $newId = $id > 0 ? $id : (count(self::$mockCollections) + 1);
            $normalized = array_merge($data, [
                'id' => $newId,
                'title' => $title,
                'slug' => $slug,
                'description' => $tagline,
                'tagline' => $tagline,
                'image_url' => $image,
                'display_order' => $order,
                'item_count' => $itemCount,
                'status' => $active === 1 ? 'active' : 'inactive',
                'is_active' => $active
            ]);
            self::$mockCollections[$newId] = $normalized;
            return $newId;
        }

        try {
            if ($id > 0) {
                $stmt = $db->prepare("
                    UPDATE `curated_collections` SET
                        `title` = :t, `slug` = :s, `tagline` = :tag, `image_url` = :img,
                        `badge` = :b, `display_order` = :ord, `is_active` = :act,
                        `product_ids_json` = :pids, `updated_at` = NOW()
                    WHERE `id` = :id
                ");
                $stmt->execute([
                    ':t' => $title, ':s' => $slug, ':tag' => $tagline, ':img' => $image,
                    ':b' => $badge, ':ord' => $order, ':act' => $active, ':pids' => $productIds, ':id' => $id
                ]);
                return $id;
            } else {
                $stmt = $db->prepare("
                    INSERT INTO `curated_collections` (
                        `title`, `slug`, `tagline`, `image_url`, `badge`, `display_order`, `is_active`, `product_ids_json`, `created_at`
                    ) VALUES (
                        :t, :s, :tag, :img, :b, :ord, :act, :pids, NOW()
                    )
                ");
                $stmt->execute([
                    ':t' => $title, ':s' => $slug, ':tag' => $tagline, ':img' => $image,
                    ':b' => $badge, ':ord' => $order, ':act' => $active, ':pids' => $productIds
                ]);
                return (int)$db->lastInsertId();
            }
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public static function createCuratedCollection(array $data): int
    {
        return self::saveCuratedCollection($data);
    }

    public static function updateCuratedCollection(int $id, array $data): bool
    {
        $data['id'] = $id;
        return self::saveCuratedCollection($data) > 0;
    }

    public static function deleteCuratedCollection(int $id): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            unset(self::$mockCollections[$id]);
            return true;
        }

        try {
            $stmt = $db->prepare("DELETE FROM `curated_collections` WHERE `id` = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // 4. CURATED PRODUCT LISTS (Featured, Best Sellers, New Arrivals)
    // ─────────────────────────────────────────────────────────────

    public static function getCuratedProductIds(string $listType): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return self::$mockCuratedLists[$listType] ?? [1, 2, 3];
        }

        try {
            $stmt = $db->prepare("SELECT `product_id` FROM `curated_product_lists` WHERE `list_type` = :lt AND `is_active` = 1 ORDER BY `sort_order` ASC");
            $stmt->execute([':lt' => $listType]);
            $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return !empty($ids) ? array_map('intval', $ids) : [1, 2, 3];
        } catch (\Throwable $e) {
            return [1, 2, 3];
        }
    }

    public static function getCuratedProducts(string $listType, bool $onlyActive = true): array
    {
        $ids = self::getCuratedProductIds($listType);
        $allProducts = ProductCatalog::getAll(true);

        $results = [];
        $catalogMap = [];
        foreach ($allProducts as $p) {
            $catalogMap[(int)$p['id']] = $p;
        }

        foreach ($ids as $pid) {
            if (isset($catalogMap[$pid])) {
                $results[] = $catalogMap[$pid];
            } else {
                // Return synthetic mock item if ID not in current catalog
                $results[] = [
                    'id' => $pid,
                    'name' => 'Royal Paithani Silk Saree #' . $pid,
                    'title' => 'Royal Paithani Silk Saree #' . $pid,
                    'sku' => 'SILK-' . str_pad((string)$pid, 4, '0', STR_PAD_LEFT),
                    'price' => 2450.00,
                    'wholesale_price' => 2450.00,
                    'featured_image' => '/assets/images/product1.png',
                    'image_url' => '/assets/images/product1.png',
                    'status' => 'in_stock'
                ];
            }
        }
        return $results;
    }

    public static function setCuratedProducts(string $listType, array $productIds): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            self::$mockCuratedLists[$listType] = array_map('intval', $productIds);
            return true;
        }

        try {
            $db->beginTransaction();
            $stmtDel = $db->prepare("DELETE FROM `curated_product_lists` WHERE `list_type` = :lt");
            $stmtDel->execute([':lt' => $listType]);

            $stmtIns = $db->prepare("
                INSERT INTO `curated_product_lists` (`list_type`, `product_id`, `sort_order`, `is_active`, `created_at`)
                VALUES (:lt, :pid, :sort, 1, NOW())
            ");
            $order = 1;
            foreach ($productIds as $pid) {
                $pidInt = (int)$pid;
                if ($pidInt > 0) {
                    $stmtIns->execute([':lt' => $listType, ':pid' => $pidInt, ':sort' => $order++]);
                }
            }
            $db->commit();
            return true;
        } catch (\Throwable $e) {
            if ($db->inTransaction()) $db->rollBack();
            return false;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // 5. ANNOUNCEMENTS & STOREWIDE MARQUEE
    // ─────────────────────────────────────────────────────────────

    public static function getAnnouncements($param1 = true, $param2 = null): array
    {
        $onlyActive = true;
        $placement = null;

        if (is_bool($param1)) {
            $onlyActive = $param1;
            if (is_string($param2) && $param2 !== '') {
                $placement = $param2;
            }
        } elseif (is_string($param1) && $param1 !== '') {
            $placement = $param1;
            if (is_bool($param2)) {
                $onlyActive = $param2;
            }
        }

        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $anns = !empty(self::$mockAnnouncements) ? array_values(self::$mockAnnouncements) : self::getFallbackAnnouncements();
            if ($onlyActive) {
                $anns = array_filter($anns, fn($a) => ($a['status'] ?? 'active') === 'active' || (int)($a['is_active'] ?? 1) === 1);
            }
            if ($placement !== null) {
                $anns = array_filter($anns, fn($a) => ($a['placement'] ?? 'topbar') === $placement);
            }
            return array_values($anns);
        }

        try {
            $where = [];
            $params = [];
            if ($onlyActive) {
                $where[] = "`is_active` = 1";
            }
            if (!empty($placement)) {
                $where[] = "`placement` = :pl";
                $params[':pl'] = $placement;
            }
            $whereSql = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
            $sql = "SELECT * FROM `announcements` {$whereSql} ORDER BY `display_order` ASC, `id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($rows) ? $rows : self::getFallbackAnnouncements();
        } catch (\Throwable $e) {
            return self::getFallbackAnnouncements();
        }
    }

    public static function saveAnnouncement(array $data): int
    {
        $db = Database::getConnection();
        $id = (int)($data['id'] ?? 0);
        $title = trim((string)($data['title'] ?? ''));
        $msg = trim((string)($data['message'] ?? ''));
        $link = trim((string)($data['link_url'] ?? ''));
        $placement = trim((string)($data['placement'] ?? 'topbar'));
        $bgColor = trim((string)($data['bg_color'] ?? '#8A681F'));
        $textColor = trim((string)($data['text_color'] ?? '#FFFFFF'));
        $isMarquee = isset($data['is_marquee']) ? (int)$data['is_marquee'] : 1;
        $isActive = isset($data['is_active']) ? (int)$data['is_active'] : (($data['status'] ?? 'active') === 'active' ? 1 : 0);
        $order = (int)($data['display_order'] ?? 1);

        if ($db === null || Database::isMockMode()) {
            $newId = $id > 0 ? $id : (count(self::$mockAnnouncements) + 1);
            $normalized = array_merge($data, [
                'id' => $newId,
                'title' => $title,
                'message' => $msg,
                'link_url' => $link,
                'placement' => $placement,
                'bg_color' => $bgColor,
                'text_color' => $textColor,
                'status' => $isActive === 1 ? 'active' : 'inactive',
                'is_active' => $isActive,
                'display_order' => $order
            ]);
            self::$mockAnnouncements[$newId] = $normalized;
            return $newId;
        }

        try {
            if ($id > 0) {
                $stmt = $db->prepare("
                    UPDATE `announcements` SET
                        `title` = :t, `message` = :m, `link_url` = :link, `placement` = :pl,
                        `bg_color` = :bg, `text_color` = :txt, `is_marquee` = :marq,
                        `is_active` = :act, `display_order` = :ord
                    WHERE `id` = :id
                ");
                $stmt->execute([
                    ':t' => $title, ':m' => $msg, ':link' => $link, ':pl' => $placement,
                    ':bg' => $bgColor, ':txt' => $textColor, ':marq' => $isMarquee,
                    ':act' => $isActive, ':ord' => $order, ':id' => $id
                ]);
                return $id;
            } else {
                $stmt = $db->prepare("
                    INSERT INTO `announcements` (`title`, `message`, `link_url`, `placement`, `bg_color`, `text_color`, `is_marquee`, `is_active`, `display_order`, `created_at`)
                    VALUES (:t, :m, :link, :pl, :bg, :txt, :marq, :act, :ord, NOW())
                ");
                $stmt->execute([
                    ':t' => $title, ':m' => $msg, ':link' => $link, ':pl' => $placement,
                    ':bg' => $bgColor, ':txt' => $textColor, ':marq' => $isMarquee,
                    ':act' => $isActive, ':ord' => $order
                ]);
                return (int)$db->lastInsertId();
            }
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public static function createAnnouncement(array $data): int
    {
        return self::saveAnnouncement($data);
    }

    public static function updateAnnouncement(int $id, array $data): bool
    {
        $data['id'] = $id;
        return self::saveAnnouncement($data) > 0;
    }

    public static function deleteAnnouncement(int $id): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            unset(self::$mockAnnouncements[$id]);
            return true;
        }

        try {
            $stmt = $db->prepare("DELETE FROM `announcements` WHERE `id` = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // 6. SEO METADATA
    // ─────────────────────────────────────────────────────────────

    public static function getSeoMetadata(string $pageRoute = '/'): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return self::$mockSeo[$pageRoute] ?? self::getFallbackSeo($pageRoute);
        }

        try {
            $stmt = $db->prepare("SELECT * FROM `seo_metadata` WHERE `page_route` = :route LIMIT 1");
            $stmt->execute([':route' => $pageRoute]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: self::getFallbackSeo($pageRoute);
        } catch (\Throwable $e) {
            return self::getFallbackSeo($pageRoute);
        }
    }

    public static function saveSeoMetadata(string $pageRoute, array $data): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            self::$mockSeo[$pageRoute] = array_merge($data, ['page_route' => $pageRoute]);
            return true;
        }

        try {
            $stmt = $db->prepare("
                INSERT INTO `seo_metadata` (`page_route`, `meta_title`, `meta_description`, `meta_keywords`, `og_title`, `og_description`, `og_image`, `canonical_url`, `updated_at`)
                VALUES (:r, :t, :d, :k, :ogt, :ogd, :og, :c, NOW())
                ON DUPLICATE KEY UPDATE
                    `meta_title` = VALUES(`meta_title`),
                    `meta_description` = VALUES(`meta_description`),
                    `meta_keywords` = VALUES(`meta_keywords`),
                    `og_title` = VALUES(`og_title`),
                    `og_description` = VALUES(`og_description`),
                    `og_image` = VALUES(`og_image`),
                    `canonical_url` = VALUES(`canonical_url`),
                    `updated_at` = NOW()
            ");
            return $stmt->execute([
                ':r' => $pageRoute,
                ':t' => $data['meta_title'] ?? '',
                ':d' => $data['meta_description'] ?? '',
                ':k' => $data['meta_keywords'] ?? '',
                ':ogt' => $data['og_title'] ?? $data['meta_title'] ?? '',
                ':ogd' => $data['og_description'] ?? $data['meta_description'] ?? '',
                ':og' => $data['og_image_url'] ?? $data['og_image'] ?? '',
                ':c' => $data['canonical_url'] ?? ''
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function setSeoMetadata(string $pageRoute, array $data): bool
    {
        return self::saveSeoMetadata($pageRoute, $data);
    }

    // ─────────────────────────────────────────────────────────────
    // 7. SHARE TEMPLATES & SOCIAL CHANNELS
    // ─────────────────────────────────────────────────────────────

    public static function getShareTemplates($channel = ''): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $all = !empty(self::$mockTemplates) ? array_values(self::$mockTemplates) : self::getFallbackTemplates();
            if (!empty($channel)) {
                $all = array_filter($all, fn($t) => ($t['channel'] ?? '') === $channel);
            }
            return array_values($all);
        }

        try {
            if (!empty($channel)) {
                $stmt = $db->prepare("SELECT * FROM `share_templates` WHERE `channel` = :ch AND `is_active` = 1");
                $stmt->execute([':ch' => $channel]);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return !empty($rows) ? $rows : self::getFallbackTemplates($channel);
            } else {
                $stmt = $db->query("SELECT * FROM `share_templates` ORDER BY `id` ASC");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return !empty($rows) ? $rows : self::getFallbackTemplates();
            }
        } catch (\Throwable $e) {
            return self::getFallbackTemplates($channel);
        }
    }

    public static function getShareTemplateByKey(string $templateKey): ?array
    {
        $all = self::getShareTemplates();
        foreach ($all as $t) {
            if (($t['template_key'] ?? '') === $templateKey) {
                return $t;
            }
        }
        return !empty($all) ? reset($all) : null;
    }

    public static function saveShareTemplate(string $channel, string $title, string $templateBody): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $id = count(self::$mockTemplates) + 1;
            self::$mockTemplates[$channel] = [
                'id' => $id,
                'channel' => $channel,
                'template_key' => $channel . '_template',
                'title' => $title,
                'content_body' => $templateBody,
                'template_body' => $templateBody,
                'is_active' => 1
            ];
            return true;
        }

        try {
            $stmt = $db->prepare("
                INSERT INTO `share_templates` (`channel`, `title`, `template_body`, `is_active`, `updated_at`)
                VALUES (:ch, :t, :b, 1, NOW())
                ON DUPLICATE KEY UPDATE
                    `title` = VALUES(`title`),
                    `template_body` = VALUES(`template_body`),
                    `updated_at` = NOW()
            ");
            return $stmt->execute([':ch' => $channel, ':t' => $title, ':b' => $templateBody]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function createShareTemplate(array $data): int
    {
        $key = trim((string)($data['template_key'] ?? 'tpl_' . time()));
        $title = trim((string)($data['title'] ?? 'Share Template'));
        $channel = trim((string)($data['channel'] ?? 'whatsapp'));
        $body = trim((string)($data['content_body'] ?? $data['template_body'] ?? ''));

        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $id = count(self::$mockTemplates) + 1;
            self::$mockTemplates[$id] = [
                'id' => $id,
                'template_key' => $key,
                'title' => $title,
                'channel' => $channel,
                'content_body' => $body,
                'template_body' => $body,
                'status' => 'active',
                'is_active' => 1
            ];
            return $id;
        }

        try {
            $stmt = $db->prepare("
                INSERT INTO `share_templates` (`template_key`, `channel`, `title`, `template_body`, `is_active`, `created_at`)
                VALUES (:k, :ch, :t, :b, 1, NOW())
            ");
            $stmt->execute([':k' => $key, ':ch' => $channel, ':t' => $title, ':b' => $body]);
            return (int)$db->lastInsertId();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public static function updateShareTemplate(int $id, array $data): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            if (isset(self::$mockTemplates[$id])) {
                self::$mockTemplates[$id] = array_merge(self::$mockTemplates[$id], $data);
            }
            return true;
        }

        try {
            $fields = [];
            $params = [':id' => $id];
            if (isset($data['title'])) { $fields[] = "`title` = :t"; $params[':t'] = $data['title']; }
            if (isset($data['channel'])) { $fields[] = "`channel` = :ch"; $params[':ch'] = $data['channel']; }
            if (isset($data['content_body'])) { $fields[] = "`template_body` = :b"; $params[':b'] = $data['content_body']; }

            if (empty($fields)) return true;
            $sql = "UPDATE `share_templates` SET " . implode(", ", $fields) . ", `updated_at` = NOW() WHERE `id` = :id";
            $stmt = $db->prepare($sql);
            return $stmt->execute($params);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function deleteShareTemplate(int $id): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            unset(self::$mockTemplates[$id]);
            return true;
        }

        try {
            $stmt = $db->prepare("DELETE FROM `share_templates` WHERE `id` = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function renderShareTemplate(string $body, array $vars): string
    {
        $result = $body;
        foreach ($vars as $key => $val) {
            $result = str_replace('{' . $key . '}', (string)$val, $result);
        }
        return $result;
    }

    public static function getSocialChannels(bool $onlyActive = true): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            $channels = !empty(self::$mockSocial) ? array_values(self::$mockSocial) : self::getFallbackSocial();
            if ($onlyActive) {
                $channels = array_filter($channels, fn($c) => ($c['status'] ?? 'active') === 'active' || (int)($c['is_active'] ?? 1) === 1);
            }
            return array_values($channels);
        }

        try {
            $sql = "SELECT * FROM `social_channels` " . ($onlyActive ? "WHERE `is_active` = 1 " : "") . "ORDER BY `sort_order` ASC";
            $stmt = $db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($rows) ? $rows : self::getFallbackSocial();
        } catch (\Throwable $e) {
            return self::getFallbackSocial();
        }
    }

    public static function createSocialChannel(array $data): int
    {
        $db = Database::getConnection();
        $key = trim((string)($data['channel_key'] ?? $data['platform'] ?? 'custom'));
        $title = trim((string)($data['title'] ?? $data['display_name'] ?? 'Social'));
        $handle = trim((string)($data['handle'] ?? ''));
        $url = trim((string)($data['url'] ?? $data['account_url'] ?? ''));
        $icon = trim((string)($data['icon_svg'] ?? $data['icon_key'] ?? $key));
        $order = (int)($data['display_order'] ?? $data['sort_order'] ?? 1);

        if ($db === null || Database::isMockMode()) {
            $id = count(self::$mockSocial) + 1;
            self::$mockSocial[$id] = [
                'id' => $id,
                'channel_key' => $key,
                'platform' => $key,
                'title' => $title,
                'display_name' => $title,
                'handle' => $handle,
                'url' => $url,
                'account_url' => $url,
                'icon_svg' => $icon,
                'icon_key' => $icon,
                'display_order' => $order,
                'sort_order' => $order,
                'status' => 'active',
                'is_active' => 1
            ];
            return $id;
        }

        try {
            $stmt = $db->prepare("
                INSERT INTO `social_channels` (`channel_key`, `platform`, `display_name`, `handle`, `account_url`, `icon_key`, `is_active`, `sort_order`, `created_at`)
                VALUES (:k, :p, :n, :h, :u, :i, 1, :ord, NOW())
            ");
            $stmt->execute([
                ':k' => $key, ':p' => $key, ':n' => $title, ':h' => $handle,
                ':u' => $url, ':i' => $icon, ':ord' => $order
            ]);
            return (int)$db->lastInsertId();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public static function updateSocialChannel(int $id, array $data): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            if (isset(self::$mockSocial[$id])) {
                self::$mockSocial[$id] = array_merge(self::$mockSocial[$id], $data);
            }
            return true;
        }

        try {
            $fields = [];
            $params = [':id' => $id];
            if (isset($data['title'])) { $fields[] = "`display_name` = :n"; $params[':n'] = $data['title']; }
            if (isset($data['handle'])) { $fields[] = "`handle` = :h"; $params[':h'] = $data['handle']; }
            if (isset($data['url'])) { $fields[] = "`account_url` = :u"; $params[':u'] = $data['url']; }
            if (isset($data['display_order'])) { $fields[] = "`sort_order` = :ord"; $params[':ord'] = (int)$data['display_order']; }
            if (isset($data['status'])) {
                $fields[] = "`is_active` = :act";
                $params[':act'] = ($data['status'] === 'active' ? 1 : 0);
            }

            if (empty($fields)) return true;
            $sql = "UPDATE `social_channels` SET " . implode(", ", $fields) . ", `updated_at` = NOW() WHERE `id` = :id";
            $stmt = $db->prepare($sql);
            return $stmt->execute($params);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function deleteSocialChannel(int $id): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            unset(self::$mockSocial[$id]);
            return true;
        }

        try {
            $stmt = $db->prepare("DELETE FROM `social_channels` WHERE `id` = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // FALLBACK DATA GENERATORS (Offline & Zero Config Guarantee)
    // ─────────────────────────────────────────────────────────────

    private static function getFallbackBanners(?string $type, bool $onlyActive): array
    {
        $all = [
            [
                'id'               => 1,
                'banner_type'      => 'hero_slider',
                'placement'        => 'hero',
                'title'            => "Surat's Premier Silk Saree Mill Hub",
                'subtitle'         => "Direct Wholesale Weaving from Surat Textile Market",
                'tagline'          => "Heritage Banarasi, Kanjivaram & Designer Georgette",
                'badge'            => "DIRECT MILL PRICING",
                'badge_text'       => "DIRECT MILL PRICING",
                'image'            => "/assets/images/hero-banner.png",
                'image_url'        => "/assets/images/hero-banner.png",
                'image_mobile'     => "/assets/images/hero-banner.png",
                'image_mobile_url' => "/assets/images/hero-banner.png",
                'bg_color'         => "#181512",
                'cta_text'         => "Browse Wholesale Lot",
                'button_text'      => "Browse Wholesale Lot",
                'cta_url'          => "/shop.php",
                'link_url'         => "/shop.php",
                'status'           => "active",
                'display_order'    => 1
            ],
            [
                'id'               => 2,
                'banner_type'      => 'hero_slider',
                'placement'        => 'hero',
                'title'            => "100% Cash On Delivery Available Across India",
                'subtitle'         => "0% Advance Risk-Free Reseller Purchasing",
                'tagline'          => "Daily Fast Dispatch via Delhivery & Express Cargo",
                'badge'            => "COD AVAILABLE",
                'badge_text'       => "COD AVAILABLE",
                'image'            => "/assets/images/product2.png",
                'image_url'        => "/assets/images/product2.png",
                'image_mobile'     => "/assets/images/product2.png",
                'image_mobile_url' => "/assets/images/product2.png",
                'bg_color'         => "#2A241E",
                'cta_text'         => "Join Reseller Network",
                'button_text'      => "Join Reseller Network",
                'cta_url'          => "/reseller.php",
                'link_url'         => "/reseller.php",
                'status'           => "active",
                'display_order'    => 2
            ],
            [
                'id'               => 3,
                'banner_type'      => 'promo_banner',
                'placement'        => 'promo_strip',
                'title'            => "Festival Wedding Silk Collection",
                'subtitle'         => "Special Wholesale Slab Discounts on Orders Above ₹15,000",
                'tagline'          => "Surat Mill Exclusive Catalogue",
                'badge'            => "FESTIVAL SPECIAL",
                'badge_text'       => "FESTIVAL SPECIAL",
                'image'            => "/assets/images/product3.png",
                'image_url'        => "/assets/images/product3.png",
                'image_mobile'     => "/assets/images/product3.png",
                'image_mobile_url' => "/assets/images/product3.png",
                'bg_color'         => "#5A4210",
                'cta_text'         => "View Wedding Catalogue",
                'button_text'      => "View Wedding Catalogue",
                'cta_url'          => "/shop.php?category=wedding",
                'link_url'         => "/shop.php?category=wedding",
                'status'           => "active",
                'display_order'    => 3
            ]
        ];

        if ($type !== null) {
            $all = array_filter($all, fn($b) => $b['banner_type'] === $type || $b['placement'] === $type);
        }
        if ($onlyActive) {
            $all = array_filter($all, fn($b) => $b['status'] === 'active');
        }
        return array_values($all);
    }

    private static function getFallbackHomepageSections(bool $onlyActive): array
    {
        return [
            ['id' => 1, 'section_key' => 'hero_slider', 'title' => 'Hero Banner Carousel', 'subtitle' => 'Main showcase', 'section_type' => 'hero_slider', 'display_order' => 1, 'is_active' => 1],
            ['id' => 2, 'section_key' => 'featured_reel', 'title' => 'Featured Designer Sarees', 'subtitle' => 'Hand-curated pieces from the weaving floor', 'section_type' => 'product_carousel', 'display_order' => 2, 'is_active' => 1],
            ['id' => 3, 'section_key' => 'collections_grid', 'title' => 'Wholesale Catalogues & Sets', 'subtitle' => 'Full lot sarees for retail textile showrooms', 'section_type' => 'collection_grid', 'display_order' => 3, 'is_active' => 1],
            ['id' => 4, 'section_key' => 'bestsellers_reel', 'title' => 'Best Selling Surat Collections', 'subtitle' => 'Top moving lots with maximum reseller profit margins', 'section_type' => 'product_carousel', 'display_order' => 4, 'is_active' => 1],
            ['id' => 5, 'section_key' => 'new_arrivals', 'title' => 'Fresh Weaving Arrivals', 'subtitle' => 'Brand new releases added today', 'section_type' => 'product_carousel', 'display_order' => 5, 'is_active' => 1]
        ];
    }

    private static function getFallbackCollections(bool $onlyActive): array
    {
        return [
            ['id' => 1, 'title' => 'Surat Wedding Silks', 'slug' => 'surat-wedding-silks', 'tagline' => 'Zari woven bridal sarees', 'description' => 'Zari woven bridal sarees', 'badge' => 'BRIDAL', 'image_url' => '/assets/images/product1.png', 'display_order' => 1, 'item_count' => 12, 'status' => 'active', 'is_active' => 1, 'product_ids_json' => '[1,2]'],
            ['id' => 2, 'title' => 'Festive Georgette Sarees', 'slug' => 'festive-georgette', 'tagline' => 'Lightweight printed & embroidery work', 'description' => 'Lightweight printed & embroidery work', 'badge' => 'TRENDING', 'image_url' => '/assets/images/product2.png', 'display_order' => 2, 'item_count' => 18, 'status' => 'active', 'is_active' => 1, 'product_ids_json' => '[3,4]'],
            ['id' => 3, 'title' => 'Pure Cotton Daily Wear', 'slug' => 'pure-cotton', 'tagline' => 'Comfortable breathable textile', 'description' => 'Comfortable breathable textile', 'badge' => 'BEST VALUE', 'image_url' => '/assets/images/product3.png', 'display_order' => 3, 'item_count' => 24, 'status' => 'active', 'is_active' => 1, 'product_ids_json' => '[5]']
        ];
    }

    private static function getFallbackAnnouncements(): array
    {
        return [
            [
                'id'            => 1,
                'title'         => 'Free Delivery Alert',
                'message'       => "Surat Mill Direct Wholesale & Reseller HUB • 100% Cash On Delivery Available • Instant Dispatch",
                'link_url'      => "/shop.php",
                'placement'     => "topbar",
                'bg_color'      => "#8A681F",
                'text_color'    => "#FFFFFF",
                'is_marquee'    => 1,
                'status'        => 'active',
                'is_active'     => 1,
                'display_order' => 1
            ]
        ];
    }

    private static function getFallbackSeo(string $pageRoute): array
    {
        return [
            'page_route'       => $pageRoute,
            'meta_title'       => "DT Brand's & Jai Hanuman Tex — Premier Surat Sarees Wholesale & Reseller HUB",
            'meta_description' => "Direct from Surat weaving mill. Premium designer sarees, wedding silks, georgette, and cotton at direct wholesale mill prices. 100% COD & fast delivery.",
            'meta_keywords'    => "surat sarees wholesale, b2b saree manufacturer, jai hanuman tex, dt brands, reseller sarees",
            'og_title'         => "DT Brand's & Jai Hanuman Tex — Premier Surat Sarees Wholesale",
            'og_description'   => "Direct from Surat weaving mill. Premium designer sarees, wedding silks, georgette, and cotton at direct wholesale mill prices.",
            'canonical_url'    => "https://jaihanumantex.in" . ($pageRoute === '/' ? '/' : $pageRoute),
            'og_image_url'     => "/assets/images/hero-banner.png",
            'og_image'         => "/assets/images/hero-banner.png"
        ];
    }

    private static function getFallbackTemplates(string $channel = ''): array
    {
        $all = [
            [
                'id'            => 1,
                'template_key'  => 'reseller_product_card',
                'channel'       => 'whatsapp',
                'title'         => 'WhatsApp Reseller Saree Share',
                'content_body'  => "Namaste! ✨ Check out this premium saree catalogue from DT Brand's & Jai Hanuman Tex:\n\n👗 *{product_title}*\n⭐ MRP: Rs. {mrp}\n💰 Reseller Price: Rs. {reseller_price}\n💎 Your Margin: Rs. {reseller_margin}\n\nDirect Loom Order Link:\n{shop_url}\n\n100% Quality Assured from Surat Mill Depot. Call/WA: {phone}",
                'template_body' => "Namaste! ✨ Check out this premium saree catalogue from DT Brand's & Jai Hanuman Tex:\n\n👗 *{product_title}*\n⭐ MRP: Rs. {mrp}\n💰 Reseller Price: Rs. {reseller_price}\n💎 Your Margin: Rs. {reseller_margin}\n\nDirect Loom Order Link:\n{shop_url}\n\n100% Quality Assured from Surat Mill Depot. Call/WA: {phone}",
                'status'        => 'active',
                'is_active'     => 1
            ],
            [
                'id'            => 2,
                'template_key'  => 'reseller_margin_share',
                'channel'       => 'reseller',
                'title'         => 'Reseller Margin Share',
                'content_body'  => "✨ *Exclusive Saree Collection* ✨\n\n*{product_title}*\nSpecial Price: Rs. {reseller_price}\n\nOrder with Cash On Delivery: {order_link}",
                'template_body' => "✨ *Exclusive Saree Collection* ✨\n\n*{product_title}*\nSpecial Price: Rs. {reseller_price}\n\nOrder with Cash On Delivery: {order_link}",
                'status'        => 'active',
                'is_active'     => 1
            ]
        ];

        if (!empty($channel)) {
            $all = array_filter($all, fn($t) => $t['channel'] === $channel);
        }
        return array_values($all);
    }

    private static function getFallbackSocial(): array
    {
        return [
            ['id' => 1, 'channel_key' => 'whatsapp', 'platform' => 'whatsapp', 'title' => 'Official WhatsApp Concierge', 'display_name' => 'Official WhatsApp Concierge', 'handle' => '+91 70463 63528', 'url' => 'https://wa.me/917046363528', 'account_url' => 'https://wa.me/917046363528', 'icon_svg' => 'whatsapp', 'icon_key' => 'whatsapp', 'status' => 'active', 'is_active' => 1, 'display_order' => 1, 'sort_order' => 1],
            ['id' => 2, 'channel_key' => 'instagram', 'platform' => 'instagram', 'title' => 'Instagram Showcase', 'display_name' => 'Instagram Showcase', 'handle' => '@dtbrands', 'url' => 'https://instagram.com/dtbrands', 'account_url' => 'https://instagram.com/dtbrands', 'icon_svg' => 'instagram', 'icon_key' => 'instagram', 'status' => 'active', 'is_active' => 1, 'display_order' => 2, 'sort_order' => 2],
            ['id' => 3, 'channel_key' => 'youtube', 'platform' => 'youtube', 'title' => 'YouTube Mill Channel', 'display_name' => 'YouTube Mill Channel', 'handle' => '@dtbrands', 'url' => 'https://youtube.com/@dtbrands', 'account_url' => 'https://youtube.com/@dtbrands', 'icon_svg' => 'youtube', 'icon_key' => 'youtube', 'status' => 'active', 'is_active' => 1, 'display_order' => 3, 'sort_order' => 3],
            ['id' => 4, 'channel_key' => 'facebook', 'platform' => 'facebook', 'title' => 'Facebook Official Page', 'display_name' => 'Facebook Official Page', 'handle' => 'dtbrands', 'url' => 'https://facebook.com/dtbrands', 'account_url' => 'https://facebook.com/dtbrands', 'icon_svg' => 'facebook', 'icon_key' => 'facebook', 'status' => 'active', 'is_active' => 1, 'display_order' => 4, 'sort_order' => 4],
            ['id' => 5, 'channel_key' => 'telegram', 'platform' => 'telegram', 'title' => 'Telegram B2B Broadcast', 'display_name' => 'Telegram B2B Broadcast', 'handle' => 'dtbrands', 'url' => 'https://t.me/dtbrands', 'account_url' => 'https://t.me/dtbrands', 'icon_svg' => 'send', 'icon_key' => 'send', 'status' => 'active', 'is_active' => 1, 'display_order' => 5, 'sort_order' => 5]
        ];
    }
}
