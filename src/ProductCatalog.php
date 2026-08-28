<?php

namespace DTBrand;

require_once __DIR__ . '/Database.php';

/**
 * ProductCatalog — Master Ethnic Saree Inventory & Merchandising Engine
 * DT Brand's & Jai Hanuman Tex — Live Hostinger Production Engine
 */
class ProductCatalog
{
    /** Neutral placeholder shown when a product genuinely has no photo on file. */
    public const NO_IMAGE = '/assets/images/no-image.svg';

    /** Statuses a customer-facing listing may show. 'draft' is deliberately absent. */
    private const PUBLIC_STATUSES = "'in_stock','low_stock','out_of_stock'";

    /** Per-request memo: one page render calls getAll() many times over. */
    private static array $memo = [];

    /** Every write path calls this so the next read re-queries the database. */
    public static function invalidateCache(): void
    {
        self::$memo = [];
    }

    /**
     * Turn whatever is stored in a media column into a URL a browser can load,
     * or '' when the stored value cannot be one.
     */
    private static function mediaPath($raw): string
    {
        $p = trim((string)$raw);
        if ($p === '' || $p === '0' || $p === 'null' || $p === 'undefined') {
            return '';
        }
        // A failed browser-side upload used to post an entire
        // "data:image/png;base64,..." URL into primary_image VARCHAR(255).
        // What survived the truncation is not an image, so it must not be
        // emitted as one.
        if (stripos($p, 'data:') === 0) {
            return '';
        }
        // The seed data shipped /Frontend/Shop/Asset/images/, a directory that
        // does not exist in this docroot, so every seeded row served a 404.
        $p = str_replace('/Frontend/Shop/Asset/images/', '/assets/images/', $p);
        if (stripos($p, 'http://') === 0 || stripos($p, 'https://') === 0) {
            return $p;
        }
        return $p[0] === '/' ? $p : '/' . $p;
    }

    /** product_media stores only image_url, so video is identified by extension. */
    private static function isVideo(string $path): bool
    {
        $clean = (string)(parse_url($path, PHP_URL_PATH) ?: $path);
        $ext = strtolower((string)pathinfo($clean, PATHINFO_EXTENSION));
        return in_array($ext, ['mp4', 'webm', 'ogg', 'ogv', 'mov', 'm4v'], true);
    }

    /**
     * A pasted YouTube / Instagram / Vimeo link. It has no file extension, so
     * without this test it would be classified as an image and rendered inside an
     * <img> tag - a guaranteed broken thumbnail. These need an iframe instead.
     */
    private static function isEmbed(string $path): bool
    {
        $host = strtolower((string)(parse_url($path, PHP_URL_HOST) ?: ''));
        if ($host === '') {
            return false;
        }
        foreach (['youtube.com', 'youtu.be', 'instagram.com', 'vimeo.com', 'facebook.com', 'fb.watch', 'dailymotion.com'] as $known) {
            if ($host === $known || str_ends_with($host, '.' . $known)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Turn a watch/share link into its embeddable player URL. Returns '' when the
     * link cannot be embedded, so the caller can refuse it rather than render an
     * iframe that shows an error page.
     */
    public static function embedUrl(string $raw): string
    {
        $raw = trim($raw);
        if ($raw === '' || !self::isEmbed($raw)) {
            return '';
        }
        $host = strtolower((string)(parse_url($raw, PHP_URL_HOST) ?: ''));
        $path = (string)(parse_url($raw, PHP_URL_PATH) ?: '');
        parse_str((string)(parse_url($raw, PHP_URL_QUERY) ?: ''), $qs);

        if (str_contains($host, 'youtu.be')) {
            $id = trim($path, '/');
            return $id !== '' ? 'https://www.youtube.com/embed/' . rawurlencode($id) : '';
        }
        if (str_contains($host, 'youtube.com')) {
            if (!empty($qs['v'])) {
                return 'https://www.youtube.com/embed/' . rawurlencode((string)$qs['v']);
            }
            if (preg_match('#/(shorts|embed|live)/([^/?&]+)#', $path, $m)) {
                return 'https://www.youtube.com/embed/' . rawurlencode($m[2]);
            }
            return '';
        }
        if (str_contains($host, 'instagram.com')) {
            if (preg_match('#/(reel|reels|p|tv)/([^/?&]+)#', $path, $m)) {
                return 'https://www.instagram.com/' . ($m[1] === 'reels' ? 'reel' : $m[1]) . '/' . rawurlencode($m[2]) . '/embed';
            }
            return '';
        }
        if (str_contains($host, 'vimeo.com')) {
            if (preg_match('#/(\d+)#', $path, $m)) {
                return 'https://player.vimeo.com/video/' . $m[1];
            }
            return '';
        }
        return '';
    }

    /** Slug form of a name: lowercase, hyphen-separated, ASCII only. */
    public static function slugify(string $text): string
    {
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $text), '-'));
        return $slug === '' ? '' : $slug;
    }

    /**
     * One query per side table for the whole page, keyed by product id, rather
     * than N queries inside the row loop.
     */
    private static function sideTables(array $ids): array
    {
        $out = ['media' => [], 'variants' => [], 'reviews' => []];
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if (empty($ids)) {
            return $out;
        }
        $in = implode(',', $ids);

        $media = Database::query(
            "SELECT product_id, image_url, is_primary, sort_order FROM product_media
             WHERE product_id IN ($in)
             ORDER BY product_id ASC, is_primary DESC, sort_order ASC, id ASC"
        );
        foreach ($media as $m) {
            $url = self::mediaPath($m['image_url'] ?? '');
            if ($url === '') {
                continue;
            }
            $out['media'][(int)($m['product_id'] ?? 0)][] = $url;
        }

        $variants = Database::query(
            "SELECT product_id, color_name, size_name, sku, stock_qty, price, image
             FROM product_variants WHERE product_id IN ($in) ORDER BY id ASC"
        );
        foreach ($variants as $v) {
            $out['variants'][(int)($v['product_id'] ?? 0)][] = [
                'sku' => trim((string)($v['sku'] ?? '')),
                'color' => trim((string)($v['color_name'] ?? '')),
                'size' => trim((string)($v['size_name'] ?? '')),
                'stock_qty' => (int)($v['stock_qty'] ?? 0),
                'price' => isset($v['price']) && $v['price'] !== null ? (float)$v['price'] : null,
                'image' => self::mediaPath($v['image'] ?? '')
            ];
        }

        // products.rating and products.reviews_count carry schema DEFAULTs of
        // 4.9 and 120, so every inserted row is born claiming reviews it does
        // not have. The reviews table is the only real source.
        $reviews = Database::query(
            "SELECT product_id, COUNT(*) AS n, AVG(rating) AS avg_rating FROM reviews
             WHERE status = 'approved' AND product_id IN ($in) GROUP BY product_id"
        );
        foreach ($reviews as $rv) {
            $out['reviews'][(int)($rv['product_id'] ?? 0)] = [
                'count' => (int)($rv['n'] ?? 0),
                'avg' => round((float)($rv['avg_rating'] ?? 0), 1)
            ];
        }
        return $out;
    }

    /**
     * Shape one products row for rendering. Every value here comes from the
     * database or is honestly empty; nothing is invented to fill a gap.
     */
    private static function mapRow(array $r, array $media, array $variants, array $review): array
    {
        $pid = (int)($r['id'] ?? 0);
        $mrp = (float)($r['mrp'] ?? 0);
        $retail = (float)($r['retail_price'] ?? 0);
        $wholesale = (float)($r['wholesale_price'] ?? 0);
        $reseller = (float)($r['reseller_price'] ?? 0);

        // Gallery order comes from product_media (already primary-first), with
        // primary_image folded in so a product saved before it had media rows
        // still shows its photo. Videos and embeds are separated out:
        // <img src="clip.mp4"> is a broken image, and a pasted YouTube or
        // Instagram link is neither a photo nor a file a <video> tag can play.
        $images = [];
        $videos = [];
        $embeds = [];
        foreach ($media as $url) {
            if (self::isEmbed($url)) {
                $embeds[] = $url;
            } elseif (self::isVideo($url)) {
                $videos[] = $url;
            } else {
                $images[] = $url;
            }
        }
        $primary = self::mediaPath($r['primary_image'] ?? '');
        if ($primary !== '' && !self::isVideo($primary) && !self::isEmbed($primary) && !in_array($primary, $images, true)) {
            array_unshift($images, $primary);
        }
        $images = array_values(array_unique($images));
        $videos = array_values(array_unique($videos));
        $embeds = array_values(array_unique($embeds));
        $hasPhoto = !empty($images);

        // Per-product colour and size exist only through product_variants;
        // product_colors and product_sizes are global palettes with no
        // product_id column, so they cannot describe one product.
        $colors = [];
        $sizes = [];
        foreach ($variants as $v) {
            if ($v['color'] !== '' && !in_array($v['color'], $colors, true)) {
                $colors[] = $v['color'];
            }
            if ($v['size'] !== '' && !in_array($v['size'], $sizes, true)) {
                $sizes[] = $v['size'];
            }
        }

        $stock = (int)($r['stock_qty'] ?? 0);
        $status = (string)($r['status'] ?? 'in_stock');
        $disc = ($mrp > 0 && $retail > 0 && $retail < $mrp)
            ? (int)round((($mrp - $retail) / $mrp) * 100) : 0;
        $rc = (int)($review['count'] ?? 0);

        $sellingType = trim((string)($r['selling_type'] ?? 'single_piece')) ?: 'single_piece';
        $custPrice = (isset($r['customer_price']) && $r['customer_price'] !== null && (float)$r['customer_price'] > 0)
            ? (float)$r['customer_price'] : null;

        $activeVariants = array_values(array_filter($variants, static function ($v) {
            return !empty($v['color']) || !empty($v['size']);
        }));
        $fullSetPieces = count($activeVariants);

        return [
            'id' => $pid,
            'sku' => trim((string)($r['sku'] ?? '')),
            'title' => trim((string)($r['title'] ?? '')),
            'name' => trim((string)($r['title'] ?? '')),
            'slug' => trim((string)($r['slug'] ?? '')),
            'category' => trim((string)($r['category_name'] ?? '')),
            'category_id' => (int)($r['category_id'] ?? 0),
            'fabric' => trim((string)($r['fabric'] ?? '')),
            'weave' => trim((string)($r['weave'] ?? '')),
            'zari_type' => trim((string)($r['zari_type'] ?? '')),
            'pallu_style' => trim((string)($r['pallu_style'] ?? '')),
            'blouse_piece' => trim((string)($r['blouse_piece'] ?? '')),
            'occasion' => trim((string)($r['occasion'] ?? '')),
            'color' => $colors[0] ?? '',
            'colors' => $colors,
            'size' => $sizes,
            'sizes' => $sizes,
            'variants' => $variants,
            'selling_type' => $sellingType,
            'is_full_set' => ($sellingType === 'full_set'),
            'is_single_piece' => ($sellingType === 'single_piece'),
            'customer_price' => $custPrice,
            'full_set_pieces' => $fullSetPieces,
            'full_set_variants' => $activeVariants,
            'mrp' => $mrp,
            'old_price' => $mrp,
            'price' => $retail,
            'retail_price' => $retail,
            'sale_price' => (float)($r['sale_price'] ?? 0),
            'sale_discount' => (float)($r['sale_price'] ?? 0),
            'effective_price' => max(0, $retail - (float)($r['sale_price'] ?? 0)),
            'effective_customer_price' => ($custPrice !== null && $custPrice > 0) ? max(0, $custPrice - (float)($r['sale_price'] ?? 0)) : max(0, $retail - (float)($r['sale_price'] ?? 0)),
            'wholesale_price' => $wholesale,
            'reseller_price' => $reseller,
            'reseller_profit' => ($reseller - $wholesale),
            'discount' => $disc,
            'moq' => (int)($r['moq_full_set'] ?? 1),
            'stock_qty' => $stock,
            'in_stock' => ($stock > 0 && $status !== 'out_of_stock'),
            'status' => $status,
            'is_featured' => ((int)($r['is_featured'] ?? 0) === 1),
            'is_bestseller' => ((int)($r['is_bestseller'] ?? 0) === 1),
            'rating' => $rc > 0 ? (float)($review['avg'] ?? 0) : 0.0,
            'reviews_count' => $rc,
            'badge' => trim((string)($r['badge'] ?? '')),
            'image' => $hasPhoto ? $images[0] : self::NO_IMAGE,
            'has_photo' => $hasPhoto,
            'gallery' => $hasPhoto ? $images : [self::NO_IMAGE],
            'images' => $images,
            'video' => $videos[0] ?? '',
            'videos' => $videos,
            // Player URLs, not the pasted watch links: an <iframe src> pointing
            // at youtube.com/watch is refused by YouTube itself.
            'embed' => isset($embeds[0]) ? self::embedUrl($embeds[0]) : '',
            'embeds' => array_values(array_filter(array_map([self::class, 'embedUrl'], $embeds))),
            'embed_links' => $embeds,
            'has_video' => (!empty($videos) || !empty($embeds)),
            'description' => trim((string)($r['description'] ?? '')),
            'moq_lots' => [
                'single' => (int)($r['moq_single'] ?? 1),
                'half_set' => (int)($r['moq_half_set'] ?? 0),
                'full_set' => (int)($r['moq_full_set'] ?? 0),
                'master_bale' => (int)($r['moq_master_bale'] ?? 0)
            ]
        ];
    }

    /**
     * Every product row, shaped for rendering.
     *
     * Drafts are excluded unless the caller is an admin surface that must see
     * them: the previous filter was `status != 'trash'`, and 'trash' is not a
     * value the ENUM can hold, so drafts were on the public storefront.
     */
    public static function getAll(bool $includeDrafts = false): array
    {
        $key = $includeDrafts ? 'all' : 'public';
        if (isset(self::$memo[$key])) {
            return self::$memo[$key];
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            // This used to return an eleven-product hardcoded catalogue, so an
            // unreachable database put merchandise that does not exist in front
            // of customers. An empty shop is honest; invented stock is not.
            return [];
        }

        $sql = "SELECT * FROM products";
        if (!$includeDrafts) {
            $sql .= " WHERE status IN (" . self::PUBLIC_STATUSES . ")";
        }
        $sql .= " ORDER BY id ASC";

        $rows = Database::query($sql);
        if (empty($rows)) {
            self::$memo[$key] = [];
            return [];
        }

        $ids = [];
        foreach ($rows as $r) {
            $ids[] = (int)($r['id'] ?? 0);
        }
        $side = self::sideTables($ids);

        $list = [];
        foreach ($rows as $r) {
            $pid = (int)($r['id'] ?? 0);
            $list[] = self::mapRow(
                $r,
                $side['media'][$pid] ?? [],
                $side['variants'][$pid] ?? [],
                $side['reviews'][$pid] ?? []
            );
        }
        self::$memo[$key] = $list;
        return $list;
    }

    /**
     * Single-row lookup. Drafts are returned so an admin edit page can still
     * open one, and so a cart line whose product was drafted still resolves.
     */
    private static function fetchOneShaped(string $where, array $params): ?array
    {
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return null;
        }
        $r = Database::fetchOne("SELECT * FROM products WHERE $where LIMIT 1", $params);
        if (empty($r)) {
            return null;
        }
        $pid = (int)($r['id'] ?? 0);
        $side = self::sideTables([$pid]);
        return self::mapRow(
            $r,
            $side['media'][$pid] ?? [],
            $side['variants'][$pid] ?? [],
            $side['reviews'][$pid] ?? []
        );
    }

    public static function getById(int $id): ?array
    {
        return $id > 0 ? self::fetchOneShaped('id = ?', [$id]) : null;
    }

    public static function getBySlug(string $slug): ?array
    {
        $slug = trim($slug);
        return $slug === '' ? null : self::fetchOneShaped('slug = ?', [$slug]);
    }

    public static function getBySku(string $sku): ?array
    {
        $sku = trim($sku);
        return $sku === '' ? null : self::fetchOneShaped('sku = ?', [$sku]);
    }

    public static function getCategories(): array
    {
        $names = [];
        foreach (self::getCategoriesWithDetails() as $c) {
            if ($c['name'] !== '') {
                $names[] = $c['name'];
            }
        }
        return array_values(array_unique($names));
    }

    /**
     * Categories with a real product count.
     *
     * categories.products_count is seeded with numbers like 840 and is not
     * maintained by any write path, so it is ignored: the count is taken from
     * the products table. Counting by category_id is authoritative, but legacy
     * rows can carry the DEFAULT category_id of 1 with a different
     * category_name, so a name count is used as a second chance.
     */
    public static function getCategoriesWithDetails(bool $activeOnly = true): array
    {
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return [];
        }

        $sql = "SELECT id, name, slug, description, image, banner_image, display_order, status FROM categories";
        if ($activeOnly) {
            $sql .= " WHERE status = 'active'";
        }
        $sql .= " ORDER BY display_order ASC, id ASC";

        $rows = Database::query($sql);
        if (empty($rows)) {
            return [];
        }

        $byId = [];
        $byName = [];
        $grouped = Database::query(
            "SELECT category_id, category_name, COUNT(*) AS n FROM products
             WHERE status IN (" . self::PUBLIC_STATUSES . ")
             GROUP BY category_id, category_name"
        );
        foreach ($grouped as $g) {
            $n = (int)($g['n'] ?? 0);
            $cid = (int)($g['category_id'] ?? 0);
            $byId[$cid] = ($byId[$cid] ?? 0) + $n;
            $cname = strtolower(trim((string)($g['category_name'] ?? '')));
            if ($cname !== '') {
                $byName[$cname] = ($byName[$cname] ?? 0) + $n;
            }
        }

        $out = [];
        foreach ($rows as $r) {
            $id = (int)($r['id'] ?? 0);
            $name = trim((string)($r['name'] ?? ''));
            $slug = trim((string)($r['slug'] ?? ''));
            $img = self::mediaPath($r['image'] ?? '');
            // The schema DEFAULT points at category-sarees.png and hero-banner.png,
            // neither of which exists in this docroot, so they mean "no image set".
            if ($img !== '' && preg_match('#/(category-sarees|hero-banner)\.png$#i', $img)) {
                $img = '';
            }
            $count = $byId[$id] ?? 0;
            if ($count === 0 && $name !== '') {
                $count = $byName[strtolower($name)] ?? 0;
            }
            $out[] = [
                'id' => $id,
                'name' => $name,
                'slug' => $slug !== '' ? $slug : self::slugify($name),
                'description' => trim((string)($r['description'] ?? '')),
                'image' => $img !== '' ? $img : self::NO_IMAGE,
                'has_image' => ($img !== ''),
                'banner_image' => self::mediaPath($r['banner_image'] ?? ''),
                'display_order' => (int)($r['display_order'] ?? 0),
                'status' => trim((string)($r['status'] ?? 'active')),
                'products_count' => $count
            ];
        }
        return $out;
    }

    public static function getRecommendations(int $currentProductId = 0, int $limit = 4): array
    {
        $all = self::getAll();
        $recommended = array_filter($all, function($p) use ($currentProductId) {
            return (int)$p['id'] !== $currentProductId;
        });
        return array_slice(array_values($recommended), 0, $limit);
    }

    /**
     * Approved review rows for one product, newest first.
     *
     * The product page used to carry seven reviews hardcoded in PHP -- named
     * shoppers in named cities, "2 days ago", helpful counts -- shown on every
     * product regardless of which one was open. Only rows a real buyer left
     * belong here, so an unreviewed product now shows an empty state.
     */
    public static function getReviews(int $productId, int $limit = 24): array
    {
        if ($productId <= 0) {
            return [];
        }
        $limit = max(1, min(100, $limit));
        $rows = Database::query(
            "SELECT id, customer_name, rating, review_title, review_text, verified_buyer, created_at
             FROM reviews
             WHERE product_id = :pid AND status = 'approved'
             ORDER BY created_at DESC, id DESC
             LIMIT $limit",
            ['pid' => $productId]
        );
        $out = [];
        foreach ($rows as $r) {
            $rating = (int)($r['rating'] ?? 0);
            $out[] = [
                'id' => (int)($r['id'] ?? 0),
                'name' => trim((string)($r['customer_name'] ?? '')),
                'rating' => max(1, min(5, $rating)),
                'title' => trim((string)($r['review_title'] ?? '')),
                'text' => trim((string)($r['review_text'] ?? '')),
                'verified' => ((int)($r['verified_buyer'] ?? 0) === 1),
                'created_at' => (string)($r['created_at'] ?? '')
            ];
        }
        return $out;
    }

    /**
     * Star histogram (5..1) over the approved reviews of one product. The page
     * printed a fixed 88 / 9 / 2 / 1 / 0 split for every product.
     */
    public static function reviewBreakdown(int $productId): array
    {
        $out = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        if ($productId <= 0) {
            return $out;
        }
        $rows = Database::query(
            "SELECT rating, COUNT(*) AS n FROM reviews
             WHERE product_id = :pid AND status = 'approved' GROUP BY rating",
            ['pid' => $productId]
        );
        foreach ($rows as $r) {
            $star = (int)($r['rating'] ?? 0);
            if (isset($out[$star])) {
                $out[$star] = (int)($r['n'] ?? 0);
            }
        }
        return $out;
    }

    /**
     * Store a shopper's review. Writes go through api/reviews.php, which already
     * queues public submissions as 'pending' and only stamps verified_buyer for
     * an admin; this class deliberately has no second insert path.
     */

    /**
     * name => hex_code for every colour in the palette, lowercased keys.
     *
     * The storefront pages each carried their own 23-entry hardcoded map of
     * colour names to hexes ('Navy' => '#1B2A4A', ...). Any colour the mill
     * actually entered that was not one of those 23 names was painted the same
     * fallback gold, so two different colours drew identical swatches. The hex
     * the admin picked in the product form is stored in product_colors.
     */
    public static function colorSwatches(): array
    {
        if (isset(self::$memo['color_swatches'])) {
            return self::$memo['color_swatches'];
        }
        $swatches = [];
        foreach (Database::query("SELECT name, hex_code FROM product_colors") as $row) {
            $name = strtolower(trim((string)($row['name'] ?? '')));
            $hex = trim((string)($row['hex_code'] ?? ''));
            if ($name !== '' && preg_match('/^#[0-9a-fA-F]{3,8}$/', $hex)) {
                $swatches[$name] = $hex;
            }
        }
        self::$memo['color_swatches'] = $swatches;
        return $swatches;
    }

    /**
     * Best available swatch colour for a colour name. Falls back to the brand
     * gold rather than an invented hue when the palette has no row for it.
     */
    public static function colorHex(string $name): string
    {
        $swatches = self::colorSwatches();
        $key = strtolower(trim($name));
        return $swatches[$key] ?? '#8A681F';
    }

    public static function filter(array $criteria = []): array
    {
        $all = self::getAll();
        return array_values(array_filter($all, function ($product) use ($criteria) {
            if (!empty($criteria['category']) && strcasecmp($product['category'], $criteria['category']) !== 0) {
                return false;
            }
            if (!empty($criteria['fabric']) && strcasecmp($product['fabric'], $criteria['fabric']) !== 0) {
                return false;
            }
            if (!empty($criteria['max_price']) && $product['retail_price'] > (float)$criteria['max_price']) {
                return false;
            }
            if (!empty($criteria['min_price']) && $product['retail_price'] < (float)$criteria['min_price']) {
                return false;
            }
            if (!empty($criteria['search'])) {
                $term = strtolower($criteria['search']);
                $title = strtolower($product['title']);
                $sku = strtolower($product['sku']);
                $cat = strtolower($product['category']);
                if (strpos($title, $term) === false && strpos($sku, $term) === false && strpos($cat, $term) === false) {
                    return false;
                }
            }
            return true;
        }));
    }

    // ─── Write helpers ──────────────────────────────────────────────────────

    /** The four values products.status may hold. */
    private const VALID_STATUSES = ['in_stock', 'low_stock', 'out_of_stock', 'draft'];

    /** Normalise a submitted status to the ENUM, or '' when unrecognised. */
    private static function normaliseStatus($raw): string
    {
        $st = str_replace([' ', '-'], '_', strtolower(trim((string)$raw)));
        if ($st === 'published' || $st === 'active') {
            $st = 'in_stock'; // legacy alias for a live product
        }
        return in_array($st, self::VALID_STATUSES, true) ? $st : '';
    }

    /**
     * Accept a media URL for storage, or '' when it is not storable.
     * A base64 data URL is rejected outright: primary_image is VARCHAR(255),
     * so storing one truncates it into a permanently broken image.
     */
    private static function storableMedia($raw): string
    {
        $p = trim((string)$raw);
        if ($p === '' || stripos($p, 'data:') === 0 || $p === 'null' || $p === 'undefined') {
            return '';
        }
        $p = str_replace('/Frontend/Shop/Asset/images/', '/assets/images/', $p);
        if (stripos($p, 'http://') !== 0 && stripos($p, 'https://') !== 0 && $p[0] !== '/') {
            $p = '/' . $p;
        }
        return strlen($p) > 255 ? '' : $p;
    }

    /** Resolve a submitted category to a real categories row where one exists. */
    private static function resolveCategory($idRaw, $nameRaw): array
    {
        $id = (int)$idRaw;
        $name = trim((string)$nameRaw);

        if ($id > 0) {
            $row = Database::fetchOne("SELECT id, name FROM categories WHERE id = ? LIMIT 1", [$id]);
            if (!empty($row)) {
                return ['id' => (int)$row['id'], 'name' => trim((string)$row['name'])];
            }
        }
        if ($name !== '') {
            $row = Database::fetchOne("SELECT id, name FROM categories WHERE name = ? LIMIT 1", [$name]);
            if (!empty($row)) {
                return ['id' => (int)$row['id'], 'name' => trim((string)$row['name'])];
            }
            $row = Database::fetchOne("SELECT id, name FROM categories WHERE slug = ? LIMIT 1", [self::slugify($name)]);
            if (!empty($row)) {
                return ['id' => (int)$row['id'], 'name' => trim((string)$row['name'])];
            }
        }
        // No matching row: keep the typed name and leave category_id at 0 rather
        // than pinning it to 1, which used to file every new product under
        // whatever category happened to be first.
        return ['id' => 0, 'name' => $name];
    }

    /** Pull the gallery / video / embed lists out of a submitted payload. */
    private static function readMediaPayload(array $data): array
    {
        $raw = [];
        foreach (['gallery', 'images', 'media', 'videos', 'video', 'embeds', 'embed'] as $k) {
            if (!isset($data[$k])) {
                continue;
            }
            $v = $data[$k];
            if (is_string($v)) {
                $decoded = json_decode($v, true);
                $v = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $v)));
            }
            if (is_array($v)) {
                foreach ($v as $item) {
                    $raw[] = is_array($item) ? ($item['url'] ?? $item['src'] ?? '') : $item;
                }
            }
        }

        $images = [];
        $videos = [];
        $embeds = [];
        foreach ($raw as $item) {
            $url = self::storableMedia($item);
            if ($url === '') {
                continue;
            }
            // An embed link is checked before the extension test: a YouTube URL
            // has no file extension, so it would otherwise be stored as a photo.
            // It is only kept when it can actually be turned into a player URL,
            // so an unusable link is refused at the door instead of becoming an
            // iframe that renders an error page.
            if (self::isEmbed($url)) {
                if (self::embedUrl($url) !== '' && !in_array($url, $embeds, true)) {
                    $embeds[] = $url;
                }
            } elseif (self::isVideo($url)) {
                if (!in_array($url, $videos, true)) {
                    $videos[] = $url;
                }
            } elseif (!in_array($url, $images, true)) {
                $images[] = $url;
            }
        }
        return ['images' => $images, 'videos' => $videos, 'embeds' => $embeds];
    }

    /** Decode a variants payload that may arrive as an array or a JSON string. */
    private static function readVariantsPayload(array $data): ?array
    {
        if (!array_key_exists('variants', $data)) {
            return null;
        }
        $v = $data['variants'];
        if (is_string($v)) {
            $v = json_decode($v, true);
        }
        return is_array($v) ? $v : [];
    }

    /**
     * Replace this product's product_media rows with exactly what was submitted.
     * Only ever called when the payload carried a media key, so a partial update
     * such as a quick stock edit cannot silently wipe a product's photos.
     */
    private static function syncMedia(int $pid, string $primary, array $images, array $videos, array $embeds = []): void
    {
        if ($pid <= 0) {
            return;
        }
        Database::execute("DELETE FROM product_media WHERE product_id = ?", [$pid]);

        $ordered = [];
        if ($primary !== '' && !self::isVideo($primary) && !self::isEmbed($primary)) {
            $ordered[] = $primary;
        }
        foreach (array_merge($images, $videos, $embeds) as $u) {
            if (!in_array($u, $ordered, true)) {
                $ordered[] = $u;
            }
        }

        $sort = 0;
        foreach ($ordered as $u) {
            // is_primary marks the thumbnail, so it may only land on a photo.
            // A video or an embed carrying the flag would make the product card
            // try to render a clip inside an <img> tag.
            $isPrimary = ($sort === 0 && !self::isVideo($u) && !self::isEmbed($u)) ? 1 : 0;
            Database::execute(
                "INSERT INTO product_media (product_id, image_url, is_primary, sort_order) VALUES (?, ?, ?, ?)",
                [$pid, $u, $isPrimary, $sort]
            );
            $sort++;
        }
    }

    /**
     * Keep the global palettes in step with what products actually use, so the
     * colour and size admin pages list real values instead of an empty table.
     */
    private static function registerPaletteColor(string $name, string $hex): ?int
    {
        if ($name === '') {
            return null;
        }
        $row = Database::fetchOne("SELECT id FROM product_colors WHERE name = ? LIMIT 1", [$name]);
        if (!empty($row)) {
            return (int)$row['id'];
        }
        $hex = preg_match('/^#[0-9a-fA-F]{3,8}$/', $hex) ? $hex : '#8A681F';
        if (Database::execute(
            "INSERT INTO product_colors (name, hex_code, status) VALUES (?, ?, 'active')",
            [mb_substr($name, 0, 50), mb_substr($hex, 0, 10)]
        )) {
            return (int)Database::lastInsertId();
        }
        return null;
    }

    private static function registerPaletteSize(string $name): ?int
    {
        if ($name === '') {
            return null;
        }
        $row = Database::fetchOne("SELECT id FROM product_sizes WHERE name = ? LIMIT 1", [$name]);
        if (!empty($row)) {
            return (int)$row['id'];
        }
        if (Database::execute(
            "INSERT INTO product_sizes (name, status) VALUES (?, 'active')",
            [mb_substr($name, 0, 50)]
        )) {
            return (int)Database::lastInsertId();
        }
        return null;
    }

    /**
     * Replace this product's product_variants rows. These are the only place the
     * schema can hold a per-product colour or size: product_colors and
     * product_sizes have no product_id column.
     */
    private static function syncVariants(int $pid, array $variants, string $baseSku): int
    {
        if ($pid <= 0) {
            return 0;
        }
        Database::execute("DELETE FROM product_variants WHERE product_id = ?", [$pid]);

        $written = 0;
        $seen = [];
        foreach ($variants as $i => $v) {
            if (!is_array($v)) {
                continue;
            }
            $color = trim((string)($v['color'] ?? $v['color_name'] ?? ''));
            $size = trim((string)($v['size'] ?? $v['size_name'] ?? ''));
            if ($color === '' && $size === '') {
                continue;
            }
            $key = strtolower($color . '|' . $size);
            if (isset($seen[$key])) {
                continue;
            }
            $seen[$key] = true;

            $sku = trim((string)($v['sku'] ?? ''));
            if ($sku === '') {
                $tail = self::slugify($color . '-' . $size);
                $sku = strtoupper(($baseSku !== '' ? $baseSku : 'DT') . '-'
                    . ($tail !== '' ? substr($tail, 0, 14) : ('V' . ($i + 1))));
            }
            $price = (isset($v['price']) && $v['price'] !== '' && (float)$v['price'] > 0)
                ? (float)$v['price'] : null;
            $stock = (int)($v['stock_qty'] ?? $v['stock'] ?? 0);
            $vImg = self::storableMedia($v['image'] ?? '');

            $ok = Database::execute(
                "INSERT INTO product_variants
                 (product_id, color_id, color_name, size_id, size_name, sku, stock_qty, price, image)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $pid,
                    self::registerPaletteColor($color, trim((string)($v['hex'] ?? $v['hex_code'] ?? ''))),
                    $color !== '' ? mb_substr($color, 0, 50) : null,
                    self::registerPaletteSize($size),
                    $size !== '' ? mb_substr($size, 0, 50) : null,
                    mb_substr($sku, 0, 50),
                    max(0, $stock),
                    $price,
                    $vImg !== '' ? $vImg : null
                ]
            );
            if ($ok) {
                $written++;
            }
        }
        return $written;
    }

    /** First free variant of a slug, so two products cannot collide on it. */
    private static function uniqueSlug(string $slug, int $ignoreId = 0): string
    {
        $slug = $slug !== '' ? $slug : 'product';
        $base = mb_substr($slug, 0, 200);
        $try = $base;
        for ($n = 2; $n < 200; $n++) {
            $row = Database::fetchOne(
                "SELECT id FROM products WHERE slug = ? AND id <> ? LIMIT 1",
                [$try, $ignoreId]
            );
            if (empty($row)) {
                return $try;
            }
            $try = $base . '-' . $n;
        }
        return $base . '-' . time();
    }

    /** First free variant of a SKU. */
    private static function uniqueSku(string $sku, int $ignoreId = 0): string
    {
        $sku = $sku !== '' ? $sku : ('DT-' . strtoupper(bin2hex(random_bytes(3))));
        $base = mb_substr($sku, 0, 40);
        $try = $base;
        for ($n = 2; $n < 200; $n++) {
            $row = Database::fetchOne(
                "SELECT id FROM products WHERE sku = ? AND id <> ? LIMIT 1",
                [$try, $ignoreId]
            );
            if (empty($row)) {
                return $try;
            }
            $try = $base . '-' . $n;
        }
        return $base . '-' . strtoupper(bin2hex(random_bytes(2)));
    }


    /**
     * Create a product from an admin submission.
     *
     * Nothing here is invented. The old version defaulted an absent price to
     * 6500/4899/1399, an absent category to 'Silk Sarees' and an absent photo to
     * product1.png - so a half-filled form produced a plausible-looking product
     * that described nothing real. Missing required values are now reported back.
     */
    public static function create(array $data): array
    {
        $title = trim((string)($data['title'] ?? $data['name'] ?? ''));
        if ($title === '') {
            return ['success' => false, 'message' => 'Product title is required.'];
        }

        $retail = (float)($data['retail_price'] ?? $data['price'] ?? 0);
        if ($retail <= 0) {
            return ['success' => false, 'message' => 'A selling price is required — enter the retail price.'];
        }
        $mrp = (float)($data['mrp'] ?? 0);
        if ($mrp <= 0) {
            $mrp = $retail; // no MRP entered means no strike-through, not a fake one
        }
        // An absent trade price means "no trade discount yet", not zero: a 0
        // would put the product on the wholesale page at no charge.
        $wholesale = (float)($data['wholesale_price'] ?? 0);
        if ($wholesale <= 0) {
            $wholesale = $retail;
        }
        $reseller = (float)($data['reseller_price'] ?? 0);
        if ($reseller <= 0) {
            $reseller = $retail;
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return ['success' => false, 'message' => 'The database is not reachable, so the product was not saved. Nothing was created.'];
        }

        $cat = self::resolveCategory($data['category_id'] ?? 0, $data['category'] ?? $data['category_name'] ?? '');
        $sku = self::uniqueSku(trim((string)($data['sku'] ?? '')));
        $slug = self::uniqueSlug(self::slugify((string)($data['slug'] ?? '')) ?: self::slugify($title));
        $status = self::normaliseStatus($data['status'] ?? '') ?: 'in_stock';

        $media = self::readMediaPayload($data);
        $primary = self::storableMedia($data['primary_image'] ?? $data['image'] ?? '');
        if ($primary === '' && !empty($media['images'])) {
            $primary = $media['images'][0];
        }

        $sellingType = (isset($data['selling_type']) && $data['selling_type'] === 'full_set') ? 'full_set' : 'single_piece';
        $custPrice = ($sellingType === 'single_piece' && isset($data['customer_price']) && (float)$data['customer_price'] > 0)
            ? (float)$data['customer_price'] : null;
        $salePrice = isset($data['sale_price']) ? max(0, (float)$data['sale_price']) : (isset($data['sale_discount']) ? max(0, (float)$data['sale_discount']) : 0.0);

        try {
            // rating and reviews_count are written as 0 on purpose: the column
            // DEFAULTs are 4.9 and 120, so every product used to be born
            // claiming a rating from reviews that were never left.
            $stmt = $pdo->prepare(
                "INSERT INTO products
                 (sku, title, slug, category_id, category_name, fabric, weave, zari_type,
                  pallu_style, blouse_piece, occasion, mrp, retail_price, customer_price, sale_price, wholesale_price,
                  reseller_price, moq_single, moq_half_set, moq_full_set, moq_master_bale,
                  stock_qty, rating, reviews_count, primary_image, badge, is_featured,
                  is_bestseller, status, selling_type, description, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, ?, ?, ?, ?, ?, ?, ?, NOW())"
            );
            $stmt->execute([
                $sku, $title, $slug, $cat['id'], $cat['name'],
                mb_substr(trim((string)($data['fabric'] ?? '')), 0, 100),
                mb_substr(trim((string)($data['weave'] ?? '')), 0, 100),
                mb_substr(trim((string)($data['zari_type'] ?? '')), 0, 100),
                mb_substr(trim((string)($data['pallu_style'] ?? $data['border'] ?? '')), 0, 100),
                mb_substr(trim((string)($data['blouse_piece'] ?? $data['blouse'] ?? '')), 0, 100),
                mb_substr(trim((string)($data['occasion'] ?? '')), 0, 100),
                $mrp, $retail, $custPrice, $salePrice, $wholesale, $reseller,
                max(1, (int)($data['moq_single'] ?? 1)),
                max(0, (int)($data['moq_half_set'] ?? 0)),
                max(0, (int)($data['moq_full_set'] ?? $data['moq'] ?? 0)),
                max(0, (int)($data['moq_master_bale'] ?? 0)),
                max(0, (int)($data['stock_qty'] ?? 0)),
                $primary,
                mb_substr(trim((string)($data['badge'] ?? '')), 0, 50),
                !empty($data['is_featured']) ? 1 : 0,
                !empty($data['is_bestseller']) ? 1 : 0,
                $status,
                $sellingType,
                trim((string)($data['description'] ?? ''))
            ]);
            $newId = (int)$pdo->lastInsertId();
            if ($newId <= 0) {
                return ['success' => false, 'message' => 'The product row was not written. Nothing was created.'];
            }

            self::syncMedia($newId, $primary, $media['images'], $media['videos'], $media['embeds']);
            $variants = self::readVariantsPayload($data);
            $variantCount = $variants === null ? 0 : self::syncVariants($newId, $variants, $sku);
            self::invalidateCache();

            $parts = [];
            $photoCount = count($media['images']) + ($primary !== '' && !in_array($primary, $media['images'], true) ? 1 : 0);
            if ($photoCount > 0) {
                $parts[] = $photoCount . ' photo' . ($photoCount === 1 ? '' : 's');
            }
            if (!empty($media['videos'])) {
                $parts[] = count($media['videos']) . ' video' . (count($media['videos']) === 1 ? '' : 's');
            }
            if (!empty($media['embeds'])) {
                $parts[] = count($media['embeds']) . ' video link' . (count($media['embeds']) === 1 ? '' : 's');
            }
            if ($variantCount > 0) {
                $parts[] = $variantCount . ' variant' . ($variantCount === 1 ? '' : 's');
            }

            return [
                'success' => true,
                'id' => $newId,
                'sku' => $sku,
                'slug' => $slug,
                'photos' => $photoCount,
                'videos' => count($media['videos']),
                'variants' => $variantCount,
                'message' => 'Product #' . $newId . ' saved'
                    . ($parts ? ' with ' . implode(', ', $parts) . '.' : '. No photo was attached, so the catalogue will show a "no photo" placeholder.')
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Update an existing product.
     *
     * Every column the admin form can edit is handled here. The old version
     * silently ignored slug, weave, category_id, the MOQ tiers, badge and all
     * media/variant data, so those edits appeared to save and then reverted on
     * reload. Media and variants are only touched when the payload actually
     * carried them, so a quick stock edit cannot wipe a product's gallery.
     */
    public static function update(int $id, array $data): array
    {
        if ($id <= 0) {
            return ['success' => false, 'message' => 'Invalid product ID.'];
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return ['success' => false, 'message' => 'The database is not reachable, so nothing was changed.'];
        }

        $fields = [];
        $params = [];
        $add = static function (string $col, $val) use (&$fields, &$params): void {
            $fields[] = $col . ' = ?';
            $params[] = $val;
        };

        if (isset($data['title']) || isset($data['name'])) {
            $t = trim((string)($data['title'] ?? $data['name']));
            if ($t === '') {
                return ['success' => false, 'message' => 'Product title cannot be empty.'];
            }
            $add('title', mb_substr($t, 0, 255));
        }
        if (isset($data['sku'])) {
            $sku = trim((string)$data['sku']);
            if ($sku !== '') {
                $add('sku', self::uniqueSku($sku, $id));
            }
        }
        if (isset($data['slug'])) {
            $slug = self::slugify((string)$data['slug']);
            if ($slug !== '') {
                $add('slug', self::uniqueSlug($slug, $id));
            }
        }
        if (isset($data['selling_type'])) {
            $st = ($data['selling_type'] === 'full_set') ? 'full_set' : 'single_piece';
            $add('selling_type', $st);
            if ($st === 'full_set') {
                $add('customer_price', null);
            }
        }
        if (isset($data['customer_price'])) {
            $curSelling = $data['selling_type'] ?? null;
            if ($curSelling !== 'full_set') {
                $cp = (float)$data['customer_price'];
                $add('customer_price', $cp > 0 ? $cp : null);
            }
        }
        if (isset($data['sale_price']) || isset($data['sale_discount'])) {
            $sp = (float)($data['sale_price'] ?? $data['sale_discount'] ?? 0);
            $add('sale_price', max(0, $sp));
        }
        foreach (['mrp', 'retail_price', 'wholesale_price', 'reseller_price'] as $col) {
            $present = isset($data[$col]) || ($col === 'retail_price' && isset($data['price']));
            if (!$present) {
                continue;
            }
            $v = (float)($data[$col] ?? $data['price'] ?? 0);
            if ($v > 0) {
                $add($col, $v);
            }
        }
        if (isset($data['stock_qty'])) {
            $add('stock_qty', max(0, (int)$data['stock_qty']));
        }
        if (isset($data['category_id']) || isset($data['category']) || isset($data['category_name'])) {
            $cat = self::resolveCategory($data['category_id'] ?? 0, $data['category'] ?? $data['category_name'] ?? '');
            if ($cat['name'] !== '') {
                $add('category_id', $cat['id']);
                $add('category_name', mb_substr($cat['name'], 0, 100));
            }
        }
        foreach (['fabric', 'weave', 'zari_type', 'occasion'] as $col) {
            if (isset($data[$col])) {
                $add($col, mb_substr(trim((string)$data[$col]), 0, 100));
            }
        }
        if (isset($data['pallu_style']) || isset($data['border'])) {
            $add('pallu_style', mb_substr(trim((string)($data['pallu_style'] ?? $data['border'])), 0, 100));
        }
        if (isset($data['blouse_piece']) || isset($data['blouse'])) {
            $add('blouse_piece', mb_substr(trim((string)($data['blouse_piece'] ?? $data['blouse'])), 0, 100));
        }
        foreach (['moq_single', 'moq_half_set', 'moq_full_set', 'moq_master_bale'] as $col) {
            if (isset($data[$col])) {
                $add($col, max(0, (int)$data[$col]));
            }
        }
        if (isset($data['badge'])) {
            $add('badge', mb_substr(trim((string)$data['badge']), 0, 50));
        }
        if (isset($data['description'])) {
            $add('description', trim((string)$data['description']));
        }
        foreach (['is_featured', 'is_bestseller'] as $col) {
            if (isset($data[$col])) {
                $flag = $data[$col];
                $add($col, (!empty($flag) && $flag !== 'false' && $flag !== '0') ? 1 : 0);
            }
        }
        $media = self::readMediaPayload($data);
        $hasMediaKey = false;
        foreach (['gallery', 'images', 'media', 'videos', 'video', 'embeds', 'embed'] as $k) {
            if (array_key_exists($k, $data)) {
                $hasMediaKey = true;
                break;
            }
        }

        // storableMedia() returns '' for a base64 data URL, so a preview blob can
        // never be written into primary_image VARCHAR(255) and truncated there.
        $primary = null;
        if (isset($data['primary_image']) || isset($data['image'])) {
            $primary = self::storableMedia($data['primary_image'] ?? $data['image']);
        }
        if (($primary === null || $primary === '') && !empty($media['images'])) {
            $primary = $media['images'][0];
        }
        if ($primary !== null) {
            $add('primary_image', $primary);
        }

        if (isset($data['status']) || isset($data['stock_status'])) {
            $st = self::normaliseStatus($data['status'] ?? $data['stock_status']);
            if ($st !== '') {
                $add('status', $st);
            }
        }

        $variants = self::readVariantsPayload($data);

        if (empty($fields) && !$hasMediaKey && $variants === null) {
            return ['success' => true, 'id' => $id, 'message' => 'No changes to update.'];
        }

        try {
            if (!empty($fields)) {
                $params[] = $id;
                $stmt = $pdo->prepare("UPDATE products SET " . implode(', ', $fields) . " WHERE id = ?");
                $stmt->execute($params);
                if ($stmt->rowCount() === 0) {
                    $exists = Database::fetchOne("SELECT id FROM products WHERE id = ? LIMIT 1", [$id]);
                    if (empty($exists)) {
                        return ['success' => false, 'message' => 'Product #' . $id . ' does not exist.'];
                    }
                }
            }
            $notes = [];
            if ($hasMediaKey) {
                $current = $primary;
                if ($current === null) {
                    $row = Database::fetchOne("SELECT primary_image FROM products WHERE id = ? LIMIT 1", [$id]);
                    $current = self::storableMedia($row['primary_image'] ?? '');
                }
                self::syncMedia($id, (string)$current, $media['images'], $media['videos'], $media['embeds']);
                $notes[] = count($media['images']) . ' photo(s)';
                if (!empty($media['videos'])) {
                    $notes[] = count($media['videos']) . ' video(s)';
                }
                if (!empty($media['embeds'])) {
                    $notes[] = count($media['embeds']) . ' video link(s)';
                }
            }
            if ($variants !== null) {
                $row = Database::fetchOne("SELECT sku FROM products WHERE id = ? LIMIT 1", [$id]);
                $notes[] = self::syncVariants($id, $variants, (string)($row['sku'] ?? '')) . ' variant(s)';
            }
            self::invalidateCache();

            return [
                'success' => true,
                'id' => $id,
                'message' => 'Product #' . $id . ' updated'
                    . ($notes ? ' (' . implode(', ', $notes) . ' saved).' : '.')
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Database update error: ' . $e->getMessage()];
        }
    }


    /**
     * Duplicate a product, including its photos, video and colour/size variants.
     *
     * The old version rebuilt the row from a handful of fields with invented
     * fallbacks ('Kanjivaram Silk', 4999, product1.png), hardcoded category_id 1
     * and copied no media or variants - so the "copy" described different
     * merchandise from the original. The copy is created as a draft, because
     * nobody has decided to sell it yet.
     */
    public static function duplicate(int $id): array
    {
        if ($id <= 0) {
            return ['success' => false, 'message' => 'Invalid product ID for duplication.'];
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return ['success' => false, 'message' => 'The database is not reachable, so nothing was duplicated.'];
        }

        $src = Database::fetchOne("SELECT * FROM products WHERE id = ? LIMIT 1", [$id]);
        if (empty($src)) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        $newTitle = mb_substr(trim((string)($src['title'] ?? 'Product')) . ' (Copy)', 0, 255);
        $newSku = self::uniqueSku(trim((string)($src['sku'] ?? '')));
        $newSlug = self::uniqueSlug(self::slugify((string)($src['slug'] ?? '')) ?: self::slugify($newTitle));

        $cols = ['sku', 'title', 'slug', 'status', 'rating', 'reviews_count'];
        $vals = [$newSku, $newTitle, $newSlug, 'draft', 0, 0];
        foreach ([
            'category_id', 'category_name', 'fabric', 'weave', 'zari_type', 'pallu_style',
            'blouse_piece', 'occasion', 'mrp', 'retail_price', 'wholesale_price',
            'reseller_price', 'moq_single', 'moq_half_set', 'moq_full_set',
            'moq_master_bale', 'stock_qty', 'primary_image', 'badge', 'is_featured',
            'is_bestseller', 'description'
        ] as $col) {
            if (array_key_exists($col, $src)) {
                $cols[] = $col;
                $vals[] = $src[$col];
            }
        }
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO products (" . implode(', ', $cols) . ", created_at) VALUES ("
                . implode(', ', array_fill(0, count($cols), '?')) . ", NOW())"
            );
            $stmt->execute($vals);
            $newId = (int)$pdo->lastInsertId();
            if ($newId <= 0) {
                return ['success' => false, 'message' => 'The duplicate row was not written.'];
            }

            Database::execute(
                "INSERT INTO product_media (product_id, image_url, is_primary, sort_order)
                 SELECT ?, image_url, is_primary, sort_order FROM product_media
                 WHERE product_id = ? ORDER BY is_primary DESC, sort_order ASC, id ASC",
                [$newId, $id]
            );

            // Fed back through syncVariants so the copy's variant SKUs are derived
            // from its own SKU instead of colliding with the original's.
            $srcVariants = Database::query(
                "SELECT color_name, size_name, stock_qty, price, image
                 FROM product_variants WHERE product_id = ? ORDER BY id ASC",
                [$id]
            );
            $variantCount = $srcVariants ? self::syncVariants($newId, $srcVariants, $newSku) : 0;
            self::invalidateCache();

            $mediaCount = (int)(Database::fetchOne(
                "SELECT COUNT(*) AS n FROM product_media WHERE product_id = ?",
                [$newId]
            )['n'] ?? 0);

            return [
                'success' => true,
                'id' => $newId,
                'sku' => $newSku,
                'title' => $newTitle,
                'message' => 'Duplicated as draft #' . $newId . ' (' . $mediaCount
                    . ' media file(s), ' . $variantCount . ' variant(s) copied). Publish it when it is ready.'
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Database duplicate error: ' . $e->getMessage()];
        }
    }


    /**
     * Adjust stock quantity by delta (increment/decrement) in MySQL
     */
    public static function adjustStock(int $id, int $delta): array
    {
        if ($id <= 0) {
            return ['success' => false, 'message' => 'Invalid product ID.'];
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            // Used to answer max(0, 50 + $delta) - a stock level for a product it
            // had never read, reported to the admin as the new truth.
            return ['success' => false, 'message' => 'The database is not reachable, so stock was not changed.'];
        }

        try {
            $stmt = $pdo->prepare("UPDATE products SET stock_qty = GREATEST(0, COALESCE(stock_qty, 0) + ?) WHERE id = ?");
            $stmt->execute([$delta, $id]);

            $get = $pdo->prepare("SELECT stock_qty, title, sku FROM products WHERE id = ? LIMIT 1");
            $get->execute([$id]);
            $row = $get->fetch();
            if (!$row) {
                return ['success' => false, 'message' => 'Product #' . $id . ' does not exist.'];
            }
            $newQty = (int)$row['stock_qty'];
            self::invalidateCache();

            return [
                'success' => true,
                'id' => $id,
                'new_stock' => $newQty,
                'message' => "Stock adjusted by {$delta} (new total: {$newQty} units)."
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Delete product permanently from database.
     * product_media and product_variants are removed by their ON DELETE CASCADE.
     */
    public static function delete(int $id, bool $permanent = true): bool
    {
        if ($id <= 0) return false;

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return false; // used to return true, so the row vanished from the UI and stayed in the table
        }
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $ok = $stmt->execute([$id]) && $stmt->rowCount() > 0;
            if ($ok) {
                self::invalidateCache();
            }
            return $ok;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * Bulk delete products permanently.
     * Returns rows actually deleted - 0 when there is no database, never the
     * length of the requested list.
     */
    public static function bulkDelete(array $ids, bool $permanent = true): int
    {
        $validIds = array_filter(array_map('intval', $ids));
        if (empty($validIds)) return 0;

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return 0;
        }
        try {
            $placeholders = implode(',', array_fill(0, count($validIds), '?'));
            $stmt = $pdo->prepare("DELETE FROM products WHERE id IN ($placeholders)");
            $stmt->execute(array_values($validIds));
            $n = $stmt->rowCount();
            if ($n > 0) {
                self::invalidateCache();
            }
            return $n;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Bulk update products. Returns the number of rows actually changed.
     */
    public static function bulkUpdate(array $ids, array $data): int
    {
        $validIds = array_values(array_filter(array_map('intval', $ids)));
        if (empty($validIds)) return 0;

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return 0; // used to report count($validIds) rows updated with no database at all
        }
        try {
            $fields = [];
            $params = [];

            if (!empty($data['category']) || !empty($data['category_name']) || !empty($data['category_id'])) {
                $cat = self::resolveCategory($data['category_id'] ?? 0, $data['category'] ?? $data['category_name'] ?? '');
                if ($cat['name'] !== '') {
                    $fields[] = 'category_id = ?';
                    $params[] = $cat['id'];
                    $fields[] = 'category_name = ?';
                    $params[] = mb_substr($cat['name'], 0, 100);
                }
            }
            foreach (['is_featured', 'is_bestseller'] as $col) {
                if (isset($data[$col])) {
                    $fields[] = $col . ' = ?';
                    $params[] = (!empty($data[$col]) && $data[$col] !== 'false' && $data[$col] !== '0') ? 1 : 0;
                }
            }
            if (isset($data['status']) || isset($data['stock_status'])) {
                $st = self::normaliseStatus($data['status'] ?? $data['stock_status']);
                if ($st !== '') {
                    $fields[] = 'status = ?';
                    $params[] = $st;
                }
            }
            foreach (['mrp', 'retail_price', 'wholesale_price', 'reseller_price'] as $col) {
                if (isset($data[$col]) && (float)$data[$col] > 0) {
                    $fields[] = $col . ' = ?';
                    $params[] = (float)$data[$col];
                }
            }
            if (isset($data['stock_qty'])) {
                $fields[] = 'stock_qty = ?';
                $params[] = max(0, (int)$data['stock_qty']);
            }
            if (empty($fields)) return 0;

            $placeholders = implode(',', array_fill(0, count($validIds), '?'));
            $stmt = $pdo->prepare("UPDATE products SET " . implode(', ', $fields) . " WHERE id IN ($placeholders)");
            $stmt->execute(array_merge($params, $validIds));
            $n = $stmt->rowCount();
            if ($n > 0) {
                self::invalidateCache();
            }
            return $n;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Update Product Status
     */
    public static function updateStatus(int $id, string $status): bool
    {
        if ($id <= 0) return false;
        $st = self::normaliseStatus($status);
        if ($st === '') {
            return false;
        }
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return false; // used to return true, so the badge flipped in the UI and nothing was stored
        }
        try {
            $stmt = $pdo->prepare("UPDATE products SET status = ? WHERE id = ?");
            $ok = $stmt->execute([$st, $id]);
            if ($ok) {
                self::invalidateCache();
            }
            return $ok;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Category CRUD: Create.
     *
     * No default image. The old version fell back to /assets/images/product1.png,
     * so every new category was illustrated with one particular saree photo.
     * getCategoriesWithDetails() reports has_image = false for an empty image and
     * the UI shows an honest placeholder instead.
     */
    public static function createCategory(array $data): array
    {
        $name = trim((string)($data['name'] ?? ''));
        if ($name === '') {
            return ['success' => false, 'message' => 'Category name is required.'];
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return ['success' => false, 'message' => 'The database is not reachable, so the category was not saved.'];
        }

        $slug = self::slugify((string)($data['slug'] ?? '')) ?: self::slugify($name);
        if ($slug === '') {
            return ['success' => false, 'message' => 'Category name must contain at least one letter or number.'];
        }

        // slug is UNIQUE: a duplicate used to surface as a raw SQL error.
        $clash = Database::fetchOne("SELECT id, name FROM categories WHERE slug = ? LIMIT 1", [$slug]);
        if (!empty($clash)) {
            return [
                'success' => false,
                'message' => 'A category with the URL "' . $slug . '" already exists ("' . $clash['name'] . '").'
            ];
        }

        $order = (int)($data['display_order'] ?? 0);
        if ($order <= 0) {
            $row = Database::fetchOne("SELECT COALESCE(MAX(display_order), 0) AS m FROM categories");
            $order = (int)($row['m'] ?? 0) + 1;
        }
        $status = strtolower(trim((string)($data['status'] ?? 'active')));
        if (!in_array($status, ['active', 'inactive'], true)) {
            $status = 'active';
        }

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO categories (name, slug, description, image, banner_image, products_count, display_order, status, created_at)
                 VALUES (?, ?, ?, ?, ?, 0, ?, ?, NOW())"
            );
            $stmt->execute([
                mb_substr($name, 0, 100),
                mb_substr($slug, 0, 100),
                trim((string)($data['description'] ?? '')),
                self::storableMedia($data['image'] ?? ''),
                self::storableMedia($data['banner_image'] ?? ''),
                $order,
                $status
            ]);
            $newId = (int)$pdo->lastInsertId();
            self::invalidateCache();
            return [
                'success' => true,
                'id' => $newId,
                'slug' => $slug,
                'message' => 'Category "' . $name . '" created (#' . $newId . ').'
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }


    /**
     * Category CRUD: Delete.
     *
     * Refuses while products still reference the category. products.category_id
     * has no foreign key, so deleting the row used to leave those products
     * pointing at an id that no longer exists - they vanished from every
     * category filter while still being on sale.
     */
    public static function deleteCategory(int $id): bool
    {
        if ($id <= 0) return false;
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return false;
        }
        if (self::categoryProductCount($id) > 0) {
            return false;
        }
        try {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            $ok = $stmt->execute([$id]) && $stmt->rowCount() > 0;
            if ($ok) {
                self::invalidateCache();
            }
            return $ok;
        } catch (\Exception $e) {
            return false;
        }
    }

    /** How many products reference this category, by id or by stored name. */
    public static function categoryProductCount(int $id): int
    {
        if ($id <= 0) {
            return 0;
        }
        $row = Database::fetchOne(
            "SELECT COUNT(*) AS n FROM products p
             WHERE p.category_id = ?
                OR p.category_name = (SELECT name FROM categories WHERE id = ?)",
            [$id, $id]
        );
        return (int)($row['n'] ?? 0);
    }

    /**
     * Category CRUD: Update. Renaming a category also re-stamps the denormalised
     * products.category_name, otherwise every product keeps the old label.
     */
    public static function updateCategory(int $id, array $data): array
    {
        if ($id <= 0) return ['success' => false, 'message' => 'Invalid category ID.'];

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return ['success' => false, 'message' => 'The database is not reachable, so nothing was changed.'];
        }

        $current = Database::fetchOne("SELECT id, name FROM categories WHERE id = ? LIMIT 1", [$id]);
        if (empty($current)) {
            return ['success' => false, 'message' => 'Category #' . $id . ' does not exist.'];
        }

        $fields = [];
        $params = [];
        $newName = null;

        if (isset($data['name'])) {
            $newName = trim((string)$data['name']);
            if ($newName === '') {
                return ['success' => false, 'message' => 'Category name cannot be empty.'];
            }
            $fields[] = 'name = ?';
            $params[] = mb_substr($newName, 0, 100);
        }
        if (isset($data['slug'])) {
            $slug = self::slugify((string)$data['slug']);
            if ($slug !== '') {
                $clash = Database::fetchOne(
                    "SELECT id FROM categories WHERE slug = ? AND id <> ? LIMIT 1",
                    [$slug, $id]
                );
                if (!empty($clash)) {
                    return ['success' => false, 'message' => 'Another category already uses the URL "' . $slug . '".'];
                }
                $fields[] = 'slug = ?';
                $params[] = mb_substr($slug, 0, 100);
            }
        }
        if (isset($data['description'])) {
            $fields[] = 'description = ?';
            $params[] = trim((string)$data['description']);
        }
        foreach (['image', 'banner_image'] as $col) {
            if (isset($data[$col])) {
                $fields[] = $col . ' = ?';
                $params[] = self::storableMedia($data[$col]);
            }
        }
        if (isset($data['display_order'])) {
            $fields[] = 'display_order = ?';
            $params[] = max(0, (int)$data['display_order']);
        }
        if (isset($data['status'])) {
            $st = strtolower(trim((string)$data['status']));
            if (in_array($st, ['active', 'inactive'], true)) {
                $fields[] = 'status = ?';
                $params[] = $st;
            }
        }

        if (empty($fields)) {
            return ['success' => true, 'id' => $id, 'message' => 'No changes.'];
        }

        try {
            $params[] = $id;
            $stmt = $pdo->prepare("UPDATE categories SET " . implode(', ', $fields) . " WHERE id = ?");
            $stmt->execute($params);

            $renamed = 0;
            $oldName = trim((string)($current['name'] ?? ''));
            if ($newName !== null && $newName !== $oldName) {
                Database::execute(
                    "UPDATE products SET category_name = ? WHERE category_id = ? OR category_name = ?",
                    [mb_substr($newName, 0, 100), $id, $oldName]
                );
                $renamed = self::categoryProductCount($id);
            }
            self::invalidateCache();

            return [
                'success' => true,
                'id' => $id,
                'message' => 'Category updated.'
                    . ($renamed > 0 ? ' ' . $renamed . ' product(s) re-labelled.' : '')
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Batch reorder categories with atomic transaction in MySQL
     */
    public static function reorderCategories(array $items): array
    {
        if (empty($items)) {
            return ['success' => false, 'message' => 'No items provided for reordering.'];
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return ['success' => false, 'message' => 'The database is not reachable.'];
        }

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("UPDATE categories SET display_order = ? WHERE id = ?");
            $updated = 0;

            foreach ($items as $idx => $item) {
                if (!is_array($item)) continue;
                $id = (int)($item['id'] ?? 0);
                $order = isset($item['display_order']) ? (int)$item['display_order'] : (isset($item['order']) ? (int)$item['order'] : ($idx + 1));
                if ($id > 0) {
                    $stmt->execute([$order, $id]);
                    $updated++;
                }
            }

            $pdo->commit();
            self::invalidateCache();

            return [
                'success' => true,
                'updated_count' => $updated,
                'message' => "Successfully updated display order for {$updated} categories."
            ];
        } catch (\Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }


    /**
     * Category CRUD: Bulk Delete. Categories that still hold products are left
     * alone, so the return value is the number genuinely removed.
     */
    public static function bulkDeleteCategories(array $ids): int
    {
        $validIds = array_values(array_filter(array_map('intval', $ids)));
        if (empty($validIds)) return 0;

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return 0;
        }
        $deleted = 0;
        foreach ($validIds as $cid) {
            if (self::deleteCategory($cid)) {
                $deleted++;
            }
        }
        return $deleted;
    }
}


