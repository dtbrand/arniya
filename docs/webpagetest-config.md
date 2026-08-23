# WebPageTest Performance Audit Configuration

## 1. Test Location & Profile

- **Location:** Mumbai, India (AWS / GCP Node)
- **Browser:** Chrome Mobile / Desktop Emulation
- **Connectivity:** 4G LTE (12 Mbps down, 5 Mbps up, 70ms latency)
- **Runs:** 3 First View + Repeat View

## 2. Monitored URLs

1. Home Page: `https://jaihanumantex.in/Frontend/Home/home.php`
2. Product Catalog: `https://jaihanumantex.in/Frontend/Shop/shop.php`
3. Single Saree Showcase: `https://jaihanumantex.in/Frontend/Single-Product/singleproduct.php`

## 3. Investigation Protocol

Run periodic deep diagnostic waterfalls before festive traffic surges to identify DNS lookup delays, SSL handshake times, and third-party script blocking.
