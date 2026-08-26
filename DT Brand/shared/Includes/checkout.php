<?php
/**
 * shared/Includes/checkout.php — RETIRED STUB
 * DT Brand's & Jai Hanuman Tex
 *
 * This file used to be a stale copy of the checkout drawer, left over from an
 * older directory layout. It was included by NO page in this project, but the
 * copy it contained had a dangerous failure path:
 *
 *   .catch(function(_err) {  // network / server error
 *       ...
 *       if (successOverlay) successOverlay.classList.add('active');
 *       localStorage.removeItem('dtbrands_cart');
 *       window.open(waUrl, '_blank');
 *   });
 *
 * In other words, when the order could NOT be saved it still showed the
 * "Order Placed Successfully!" overlay and wiped the shopper's bag. The order
 * existed nowhere — not in the database, not in the admin — yet the customer
 * was told it was placed and lost their cart.
 *
 * It also built the WhatsApp invoice from client-side cart prices with no GST
 * line, so the total messaged to the mill understated the real amount.
 *
 * Rather than leave that code in the repo where it could be included by
 * accident (the path differs from the real one by a single directory), the body
 * has been removed. The real checkout drawer lives in shared/checkout.php and
 * is included by index.php, shop.php, product.php, cart.php, wishlist.php,
 * reseller.php, retailer.php and wholesale.php. It only reports success when
 * the API confirms the order was written, prices every line server-side, and
 * messages the totals the server actually recorded.
 *
 * The original contents remain in git history if they are ever needed.
 */

// Nothing is emitted. Include shared/checkout.php instead.
