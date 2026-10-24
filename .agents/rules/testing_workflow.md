# Pre-Production Testing & Quality Assurance Guidelines

After completing any new feature or bugfix, the following process **MUST** be executed before committing or pushing code to production.

---

## 1. Test-Driven Development (TDD)
- **Design Before Implementation**: Understand specifications, edge cases, and boundary constraints before writing production code.
- **Fail-Safe Behavior**: Explicitly write test assertions verifying that external services (e.g., Firebase FCM, SMS/WhatsApp gateways, third-party APIs) fail gracefully without breaking core database transactions or returning 500 errors to end users.
- **SOLID Architecture**: Ensure code adheres to SOLID principles (Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion) to keep units easily mockable and testable.

---

## 2. Unit Testing
- **Backend (Laravel)**:
  - Run the complete unit test suite:
    ```bash
    php artisan test --testsuite=Unit
    ```
  - For new features, always create/update corresponding unit tests in `tests/Unit/`.
  - Verify 100% passing status with zero regressions.
- **Mobile (Flutter `cpa_mobile`)**:
  - Run static analysis to detect errors or deprecations:
    ```bash
    flutter analyze
    ```
  - Run unit and widget tests:
    ```bash
    flutter test
    ```

---

## 3. Integration Testing
- **Component & Database Lifecycle**:
  - Test end-to-end interactions between Controllers, Services, Observers, and Eloquent Models.
  - Verify that Eloquent model events (e.g. `Order::created`, `Order::updated`) trigger relevant background services and observers accurately.
- **API Endpoints**:
  - Validate request payload schemas, authentication guards (`auth:sanctum`), and status codes (200/201 vs 401/403/422).
  - Verify database state changes (e.g. order records, token associations).
- **Graceful Degradation**:
  - Verify system behavior when dependent external services are unreachable or unconfigured.

---

## 4. Production Readiness Checklist
Before marking any feature as ready for production:
1. All Unit & Integration tests execute and pass (`php artisan test`).
2. Static code analyzer reports zero errors (`flutter analyze` / `pint`).
3. Database migrations are idempotent (`if (!Schema::hasTable(...))`, `if (!Schema::hasColumn(...))`).
4. Sensitive keys, service account JSON files, and tokens are stored in `.env` or secure ignored paths—never committed to version control.
