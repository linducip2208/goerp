# GoERP — System Architecture

## Technology Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 (PHP 8.3) |
| Database | MySQL 8 |
| Admin Panel | Filament 3.3 |
| Frontend (Public) | Blade + TailwindCSS |
| API (Mobile) | Laravel Sanctum |
| Mobile | Flutter (future) |
| Queue | Redis + Laravel Horizon |
| Search | Meilisearch |
| Storage | S3-compatible (Cloudflare R2 / MinIO) |

---

## Three-Layer Architecture

```
+====================================================================+
|                    LAYER 1: SaaS Management                        |
|  Tenant · Subscription · Billing · Backoffice · Feature Flags      |
+====================================================================+
                                  |
+====================================================================+
|                    LAYER 2: Core ERP / Accounting                  |
|  Sales · Purchase · Cash & Bank · Expense · Inventory · Accounting |
|  Asset · Contacts · Reports                                        |
+====================================================================+
                                  |
+====================================================================+
|                    LAYER 3: Operational Modules                    |
|  Production · Multi Warehouse · Marketplace Excel · SKU Matching   |
+====================================================================+
```

---

## Accounting Flow (Transaction → Report)

```
TRANSACTION → SUB-LEDGER → JOURNAL ENTRY → GENERAL LEDGER → TRIAL BALANCE → FINANCIAL REPORT
     │              │            │               │                │               │
  Sales Order   Sales Inv    Dr Piutang     Mutasi per COA   Neraca Saldo    Laba Rugi
  Purchase Ord  Purch Inv    Cr Penjualan   Saldo akhir      Per Akun        Neraca
  Delivery      Payment      Dr HPP                          Balance Check   Cash Flow
  Stock Move    Receipt      Cr Inventory                                    Equity
```

**Every operational transaction must connect to an accounting ledger entry.** No standalone transaction without journal post.

---

## Multi-Tenant Data Isolation

```
SUPER ADMIN / BACKOFFICE
│
├── Tenant A (PT ABC Fashion)
│   ├── Company A1 (PT ABC Fashion Main)
│   │   ├── Branch: Jakarta Pusat
│   │   │   └── Warehouse: Gudang Utama, Gudang Online
│   │   └── Branch: Bandung
│   │       └── Warehouse: Gudang Bandung
│   ├── Company A2 (CV ABC Store)
│   └── Subscription: Business Plan
│
├── Tenant B (PT XYZ Manufacturing)
│   ├── Company B1
│   └── Subscription: Enterprise Plan
│
└── Tenant C (Trial User)
    └── Subscription: Trial (expired)
```

**Rule:** Every business record MUST have `tenant_id`. Company records also have `company_id`. Branch/warehouse records have `branch_id`/`warehouse_id` where applicable.

---

## Directory Structure

```
goerp/
├── app/
│   ├── Console/Commands/         # Artisan commands (scheduler, backup, etc.)
│   ├── Filament/                 # Admin panel
│   │   ├── Pages/                # Custom pages (reports, dashboard)
│   │   ├── Resources/            # CRUD resources per module
│   │   └── Widgets/              # Dashboard widgets (per-role)
│   ├── Http/
│   │   ├── Controllers/          # Public + API controllers
│   │   └── Middleware/           # Tenant isolation, subscription check
│   ├── Models/                   # Eloquent models
│   ├── Providers/                # Service providers
│   ├── Services/                 # Business logic services
│   │   ├── Accounting/           # Journal, ledger, closing
│   │   ├── Inventory/            # Stock movement, valuation
│   │   ├── Marketplace/          # Excel import, SKU matching
│   │   ├── Production/           # BOM, WIP, cost calculation
│   │   ├── SaaS/                 # Subscription, billing, tenant
│   │   └── Seo/                  # PSEO, IndexNow, sitemap
│   └── Enums/                    # Status enums, types
├── database/
│   └── migrations/               # ~60+ migration files
├── docs/                         # This documentation
├── routes/
│   ├── web.php                   # Public + admin routes
│   ├── api.php                   # API routes (mobile, integration)
│   └── console.php               # Scheduler
└── resources/
    └── views/                    # Blade templates
```

---

## Core Design Principles

### 1. Tenant Isolation (by `tenant_id`)
Every query scoped to current tenant. Global scope `TenantScope` on all tenant-owned models.

### 2. Transaction → Journal Auto-Post
Sales invoice posted → auto-generates journal (Dr Piutang, Cr Penjualan). Purchase invoice posted → auto-generates journal (Dr Inventory, Cr Hutang). Payment received → auto-generates journal (Dr Bank, Cr Piutang).

### 3. Internal SKU as Single Source of Truth
All modules reference the same `products` table via `internal_sku`. Marketplace SKU is mapped to internal SKU via `marketplace_sku_mapping`.

### 4. Approval Workflow
Configurable per transaction type. Multi-level approval based on amount thresholds. Draft → Submitted → Waiting Approval → Approved → Posted.

### 5. Audit Trail
Every important mutation logged: user, timestamp, module, document, old value, new value, IP, device.

### 6. No Hardcoded Providers
All integrations (payment, SMS, storage, AI) use format-based dynamic adapters. User configures via admin UI.

---

## API Design (for Mobile App — Future)

| Endpoint Group | Description |
|---------------|-------------|
| `/api/auth/*` | Login, logout, register, password reset |
| `/api/dashboard/*` | Stats, charts, quick actions |
| `/api/sales/*` | Quotations, orders, invoices, payments |
| `/api/purchases/*` | POs, receipts, invoices, payments |
| `/api/inventory/*` | Stock balance, movement, transfer |
| `/api/production/*` | Production orders, work orders, QC |
| `/api/marketplace/*` | Import orders, SKU matching history |
| `/api/reports/*` | Financial, sales, inventory reports |

Auth: Laravel Sanctum (token-based). All endpoints require `Accept: application/json` header. Response format follows JSON:API conventions.

---

## Security Model

- **Tenant isolation**: global scope on all models, middleware checks `tenant_id` from authenticated user
- **Role-based access**: Owner, Finance, Accounting, Purchasing, Warehouse, Production, Sales, Auditor
- **Permission granularity**: View, Create, Edit, Delete, Approve, Export, Print per menu
- **API rate limiting**: per-tenant, per-user via Laravel's built-in throttle
- **Encrypted secrets**: all API keys, provider credentials encrypted at rest
- **Audit trail**: all mutations logged immutably
