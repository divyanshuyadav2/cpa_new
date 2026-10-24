# Workspace Guidelines & Production Deployment Rules

## Pre-Production Verification Process
After completing any feature or modification, always follow this verification workflow before pushing code to production:

### 1. Test-Driven Development (TDD)
- Define and write test specifications for new features before or alongside implementation.
- Cover positive cases, edge cases, input validation, and boundary conditions.
- Design with SOLID principles so services, interfaces, and observers are isolated, mockable, and testable.
- Ensure graceful degradation: external services (Firebase, SMS, Mail) must never crash core transaction flows.

### 2. Unit Testing
- **Backend (Laravel)**:
  ```bash
  php artisan test --testsuite=Unit
  ```
  All tests must pass with 0 failures before proposing or committing code.
- **Mobile (Flutter `cpa_mobile`)**:
  ```bash
  flutter analyze
  flutter test
  ```
  Ensure 0 syntax, type, or lint errors.

### 3. Integration Testing
- Test cross-component workflows (Controllers -> Services -> Observers -> Database).
- Test protected API endpoints under `auth:sanctum` with valid and invalid payloads.
- Verify reactive model events (e.g., `Order` created/status changes) dispatch expected background actions.

### 4. Production Checklist
- [ ] All unit and integration tests pass cleanly.
- [ ] No regression on existing features.
- [ ] Sensitive secrets and credentials (API keys, service-account.json) are kept in `.env` / ignored files.
- [ ] Database migrations are safe and idempotent.
