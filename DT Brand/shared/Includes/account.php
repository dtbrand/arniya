<?php
/**
 * shared/Includes/account.php — RETIRED STUB
 * DT Brand's & Jai Hanuman Tex
 *
 * This file used to be a 1,398-line copy of the account/login modal, left over
 * from an older directory layout (its links pointed at /Frontend/Reseller/…,
 * /Frontend/Wholesale/… and /shop — none of which exist any more).
 *
 * It was included by NO page in this project, but the copy it contained was the
 * pre-fix version of the modal, which:
 *   - logged a visitor in without ever checking the password server-side, and
 *   - let a visitor pick "Wholesaler" for themselves and receive B2B pricing, and
 *   - shipped a quickDemoLogin() helper that wrote a fully-privileged session
 *     straight into localStorage.
 *
 * Rather than leave that code sitting in the repo where it could be included by
 * accident, the body has been removed. The real, server-validated account modal
 * lives in shared/account.php and is included by index.php, shop.php,
 * product.php, reseller.php, retailer.php and wholesale.php.
 *
 * The original contents remain in git history if they are ever needed.
 */

// Nothing is emitted. Include shared/account.php instead.
