# Bug Lifecycle & Regression Prevention Standard

## 1. Bug Fix Lifecycle

```text
1. Reproduce ➔ 2. Root Cause Analysis ➔ 3. Write Failing Test (Red) ➔
4. Implement Fix ➔ 5. Test Passes (Green) ➔ 6. PR & CI Validation ➔ 7. Staging ➔ 8. Production Verification
```

## 2. Mandatory Rules

- No bug fix PR will be approved without an accompanying automated test case in `tests/Unit/` or `tests/e2e/`.
- Every fixed issue must reference the original issue number in the commit message (`fix(cart): resolve quantity calculation (#12)`).
