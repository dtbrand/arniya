# DT Brand's Performance Benchmarks & Measurement Standard

## 1. Production Performance Targets

- **TTFB (Time to First Byte):** < 350ms on Indian CDN / edge cache
- **FCP (First Contentful Paint):** < 1.2s on 4G Mobile / Desktop
- **LCP (Largest Contentful Paint):** < 2.5s
- **CLS (Cumulative Layout Shift):** < 0.1
- **API Response Latency:** < 150ms for cart and pricing lookups

## 2. Measurement Strategy

- Routine execution of `php scripts/benchmark.php` across live endpoints.
- Lighthouse CI automated regression tracking on pull requests.
- Asset compression via Apache `mod_deflate` and browser cache headers enabled in `.htaccess`.
