# Incident Postmortem Template

**Incident ID:** INC-YYYYMMDD-01  
**Date:** YYYY-MM-DD  
**Severity:** P1 (Critical) / P2 (High) / P3 (Medium)  
**Author:** DT Brand's Engineering  
**Status:** Resolved

---

## 1. Summary

Brief 2-3 sentence description of the incident and business impact.

## 2. Impact

- **Customer Facing:** (e.g. 15 checkout requests delayed)
- **Financial / Orders:** (e.g. 0 revenue lost)
- **Duration:** XX minutes

## 3. Timeline (IST)

- **HH:MM** — Incident detected by automated health check / alert.
- **HH:MM** — Root cause identified.
- **HH:MM** — Fix / rollback deployed.
- **HH:MM** — System verified operational.

## 4. Root Cause

Detailed technical explanation of what caused the failure.

## 5. Corrective & Preventive Actions

- [ ] Implement regression test in `tests/`
- [ ] Update monitoring thresholds
- [ ] Documentation update
