# GoERP — Modules & Features Index

**Total: 16 Modules, 122 Features**

---

## Module Map

```
GoERP
├── A. SaaS & Multi-Tenant          (6 features)
├── B. Dashboard & Navigation       (5 features)
├── C. Sales                        (9 features)
├── D. Purchase                     (7 features)
├── E. Product & Inventory          (9 features)
├── F. Cash, Bank, Expense, Contact (7 features)
├── G. Accounting Core              (7 features)
├── H. Fixed Assets & Reports       (8 features)
├── I. Approval & Audit             (3 features)
├── J. Marketplace Excel            (10 features)
├── K. Production                   (13 features)
├── L. Settings                     (12 features)
├── M. SaaS Backoffice              (16 features)
├── N. Database Structure           (5 schema groups)
├── O. Roadmap                      (5 phases)
└── P. System Overview              (1 diagram)
```

---

## A. SaaS & Multi-Tenant (6)

| # | Feature | Description |
|---|---------|-------------|
| 1 | Multi-Tenant Architecture | One app serves many customers. Tenant = data boundary |
| 2 | Data Isolation | Every record has `tenant_id`. No cross-tenant data leak |
| 3 | Login & Subscription Check | Validate user → tenant → subscription status. Expired = view-only |
| 4 | Multi-Company | One tenant can have multiple companies. Switch from header |
| 5 | Multi-Branch | Company can have branches with PIC, default warehouse |
| 6 | Role & Permission | View, Create, Edit, Delete, Approve, Export, Print per menu |

---

## B. Dashboard & Navigation (5)

| # | Feature | Description |
|---|---------|-------------|
| 7 | Main Dashboard | Cash, AR, AP, Inventory summary cards + filter by company/branch/period |
| 8 | Sales Chart | Bar/line chart with day/week/month/year, comparison to previous period |
| 9 | Cash Flow Summary | Cash in, cash out, net for selected period |
| 10 | Quick Actions | Shortcut buttons: +Invoice, +SO, +PO, +Expense, +Payment, +Product, +Contact |
| 11 | Global Search & Notifications | Search invoice/PO/product/contact/journal. Notifications for due/approval/low stock |

---

## C. Sales (9)

| # | Feature | Description |
|---|---------|-------------|
| 12 | Sales Flow | Quotation → SO → Delivery → Invoice → Payment |
| 13 | Sales Quotation | Create quote, send, accept/reject, convert to SO without re-input |
| 14 | Sales Order | Confirmed orders. Reserve stock. Partial fulfillment tracking |
| 15 | Delivery | Goods out with partial delivery. Track remaining SO qty |
| 16 | Sales Invoice | Primary billing doc. Customer, items, discount, tax, total |
| 17 | Invoice Status | Draft → Open → Partial → Paid → Overdue |
| 18 | Customer Payment | Full or partial payment against invoice. Updates AR |
| 19 | Sales Return | Return goods → stock in → refund or credit note |
| 20 | Auto Journal (Sales) | Dr AR Cr Sales, Dr COGS Cr Inventory, Dr Bank Cr AR |

---

## D. Purchase (7)

| # | Feature | Description |
|---|---------|-------------|
| 21 | Purchase Flow | PO → Receipt → Invoice → Payment |
| 22 | Purchase Order | Supplier order with approval. Expected delivery date |
| 23 | Goods Receipt | Stock in according to actual received, not PO. Partial receiving |
| 24 | Purchase Invoice | Supplier bill → forms AP |
| 25 | Supplier Payment | Full or partial. Updates AP |
| 26 | Purchase Return | Return to supplier → stock out → AP reduction/refund |
| 27 | Auto Journal (Purchase) | Dr Inventory Cr AP, Dr AP Cr Bank |

---

## E. Product & Inventory (9)

| # | Feature | Description |
|---|---------|-------------|
| 28 | Product Master | Name, SKU, barcode, category, brand, unit, cost/sell price, COA links |
| 29 | Product Variants | Color, size, attributes → each combo = unique internal SKU |
| 30 | Internal SKU as Master | Single source of truth for all modules |
| 31 | Multi-Warehouse | Per-warehouse stock tracking |
| 32 | Stock Balance | On Hand / Reserved / Available per SKU per warehouse |
| 33 | Stock Movement | Immutable log of every stock change with before/after |
| 34 | Warehouse Transfer | Move stock between warehouses. Draft → In Transit → Received |
| 35 | Stock Adjustment | Manual correction: in, out, lost, damage, reject, correction |
| 36 | Stock Opname | System vs physical → variance → approval → adjustment |

---

## F. Cash, Bank, Expense, Contacts (7)

| # | Feature | Description |
|---|---------|-------------|
| 37 | Cash & Bank | Account register, receive/send/transfer money |
| 38 | Receive Money | Cash in not from invoice payment |
| 39 | Send Money | Cash out to expense/asset account |
| 40 | Inter-Bank Transfer | Move funds between company accounts |
| 41 | Bank Reconciliation | Match system transactions with bank statement |
| 42 | Expense | Operational costs by category, branch, department |
| 43 | Contacts | Customer, Supplier, Employee, Other — with NPWP, payment terms, credit limit |

---

## G. Accounting Core (7)

| # | Feature | Description |
|---|---------|-------------|
| 44 | Chart of Accounts (COA) | Hierarchical account tree. 1-Asset, 2-Liability, 3-Equity, 4-Revenue, 5-COGS, 6-Expense, 7-Other Income, 8-Other Expense |
| 45 | Journal Entries | Auto-generated from transactions. View all entries |
| 46 | Manual Journal | Manual adjustment. Debit must equal credit |
| 47 | General Ledger | Per-account mutation and balance. Opening → movements → closing |
| 48 | Opening Balance | Set initial positions when migrating to system |
| 49 | Lock Period | Prevent edits/backdate in locked periods |
| 50 | Period Closing | Reconcile → close → transfer P&L to retained earnings |

---

## H. Fixed Assets & Reports (8)

| # | Feature | Description |
|---|---------|-------------|
| 51 | Fixed Assets | Register, category, acquisition, depreciation schedule |
| 52 | Profit & Loss | Revenue - COGS = Gross Profit - Expenses = Net Profit |
| 53 | Balance Sheet | Assets = Liabilities + Equity |
| 54 | Cash Flow | Operating, investing, financing cash flows |
| 55 | Trial Balance | All account balances. Debits = Credits |
| 56 | Sales Reports | By product, customer, salesperson, channel, branch, date |
| 57 | Purchase Reports | By supplier, product, branch. AR/AP aging |
| 58 | Inventory Reports | Stock summary, detail, card, valuation, movement, low stock, negative stock |

---

## I. Approval & Audit (3)

| # | Feature | Description |
|---|---------|-------------|
| 59 | Approval Workflow | Draft → Submitted → Waiting Approval → Approved → Posted / Rejected |
| 60 | Approval Rules | Multi-level by amount. <5M: Supervisor, 5-50M: Manager, >50M: Owner |
| 61 | Audit Trail | Every mutation: user, datetime, module, doc, old value, new value, IP, device |

---

## J. Marketplace Excel (10)

| # | Feature | Description |
|---|---------|-------------|
| 62 | Marketplace V1 Concept | No API. User downloads Excel from marketplace, uploads to GoERP |
| 63 | Import Orders | Select marketplace, warehouse, upload XLSX/XLS/CSV |
| 64 | Data Read | Parse: order no, date, marketplace SKU, product name, variant, qty, price |
| 65 | Auto SKU Match | If marketplace SKU = internal SKU → auto-connect |
| 66 | Manual SKU Match | Select internal product, save mapping for future imports |
| 67 | Bulk SKU Matching | Resolve all unmatched SKUs in one interface |
| 68 | Preview Import | Show total orders, items, matched, unmatched, duplicates. Block if unmatched exists |
| 69 | Duplicate Protection | Check DB. Skip if order already imported |
| 70 | Stock Deduction | After import, create stock movement on internal SKU |
| 71 | Import History | Log all imports: date, marketplace, file, orders, items, status |

---

## K. Production (13)

| # | Feature | Description |
|---|---------|-------------|
| 72 | Production Flow | BOM → Production Order → Material Request → Issue → WIP → Output → QC |
| 73 | Bill of Materials (BOM) | Material requirements per production unit |
| 74 | BOM Versioning | New BOM version = new record. Old POs keep their selected version |
| 75 | Production Order | Product, target qty, BOM version, start/end dates, warehouses |
| 76 | Work Orders | Per-stage: cutting, sewing, finishing, QC, packing. Team/operator tracking |
| 77 | Material Request | Production requests raw materials from warehouse |
| 78 | Material Issue | Warehouse issues materials → stock decreases → value to WIP |
| 79 | WIP (Work In Progress) | Track goods in production before becoming finished |
| 80 | Material Variance | Standard BOM qty vs actual usage |
| 81 | Production Output & QC | Good / Reject / Rework classification |
| 82 | Reject & Rework | Defect tracking with reasons. Rework goes back to production |
| 83 | Production Cost | Calculate actual HPP = total cost / good output |
| 84 | Borongan (Piece Rate) | Labor payment by output per operation per operator |

---

## L. Settings (12)

| # | Feature | Description |
|---|---------|-------------|
| 85 | Settings Structure | Grouped by module: company, sales, purchase, inventory, production, marketplace, accounting, tax, notification |
| 86 | Company Settings | Logo, name, legal name, NPWP, NIB, address, timezone, fiscal year, currency |
| 87 | Accounting Settings | Default COA accounts for auto-posting |
| 88 | Inventory Settings | Costing method, negative stock toggle, multi-warehouse, alert |
| 89 | Sales Settings | Default warehouse, tax, payment term, credit limit, approval |
| 90 | Purchase Settings | Default warehouse, tax, approval, allow over-receipt |
| 91 | Production Settings | Warehouse accounts (raw, WIP, finished, reject), cost account |
| 92 | Marketplace Settings | Require SKU match, reduce stock, create SO, create invoice, post journal |
| 93 | Transaction Number | Configurable format: INV/{YYYY}/{MM}/{####} |
| 94 | Tax Settings | Name, rate, type, inclusive/exclusive, account |
| 95 | Multi-Currency | Base + transaction currency with exchange rate |
| 96 | Attachment & Notification | File attachments on transactions. Notification rules |

---

## M. SaaS Backoffice (16)

| # | Feature | Description |
|---|---------|-------------|
| 97 | Backoffice Overview | Separate admin for platform owner |
| 98 | Backoffice Dashboard | Tenant count, active/trial/expired, MRR, outstanding |
| 99 | Tenant Management | List all customers with package, dates, users, status |
| 100 | Tenant Detail | Companies, subscription, users, features, usage, billing, support |
| 101 | Subscription Plans | Manage 4 plan tiers without code changes |
| 102 | Feature Entitlement | Per-plan feature flags (accounting, inventory, production, etc.) |
| 103 | Package Limits | Max users, companies, branches, warehouses, storage |
| 104 | Subscription Status | Trial → Active → Due → Grace → Suspended |
| 105 | Expired Tenant Handling | View-only access. Can renew. Data not deleted |
| 106 | Billing | Invoice, payment, renewal, discount, coupon, tax |
| 107 | Usage Monitor | Track limit usage per tenant |
| 108 | Feature Control | Toggle features per tenant (override plan) |
| 109 | Impersonation | Superadmin login as tenant user (logged) |
| 110 | Support Tickets | Tenant can create ticket. Staff respond |
| 111 | Announcements | Broadcast to all or specific tenants/plans |
| 112 | Backup | History, schedule, restore control |

---

## N. Database Structure (5 groups)

| # | Group | Table Count |
|---|-------|-------------|
| 113 | Core | tenants, companies, branches, users, roles, permissions, contacts, products, product_variants, categories, warehouses, inventory_balances, inventory_movements, settings |
| 114 | Marketplace | marketplace_imports, marketplace_orders, marketplace_order_items, marketplace_sku_mapping |
| 115 | Production | production_boms, production_bom_items, production_orders, work_orders, material_requests, material_issues, production_outputs, production_rejects, piece_rates |
| 116 | SaaS | subscription_plans, subscriptions, subscription_invoices, subscription_payments, feature_flags, support_tickets, announcements, impersonations |
| 117 | Accounting + Sales + Purchase | All sales/purchase/accounting/bank/asset tables |

---

## O. Roadmap (5 Phases)

| Phase | Focus | Features |
|-------|-------|----------|
| **1** | Core SaaS + Accounting | Tenant, subscription, backoffice, dashboard, sales, purchase, cash/bank, expense, products, basic inventory, contacts, full accounting (COA, journal, ledger), reports, users, roles, settings |
| **2** | Operational Control | Multi-warehouse, stock opname, approval workflow, audit trail, fixed assets, lock period, closing, advanced reports |
| **3** | Production | BOM, production orders, work orders, material request/issue, WIP, QC, reject/rework, production cost, borongan |
| **4** | Marketplace | Excel import for Shopee/TikTok/Lazada, SKU matching, duplicate protection, stock deduction |
| **5** | Advanced (Future) | Marketplace API, customer portal, multi-currency, budgeting, AI forecasting, mobile app (Flutter) |

---

## P. System Overview

```
+-------------------------------------------------------------------+
|                    SaaS Management Layer                          |
|  Admin Backoffice · Tenant Mgmt · Subscription · Billing · Feature Control |
+-------------------------------------------------------------------+
                                  |
+-------------------------------------------------------------------+
|                    Core ERP / Accounting Layer                     |
|  Sales · Purchase · Cash & Bank · Expense · Inventory · Accounting|
|  Asset · Contacts · Reports · Approval · Audit Trail              |
+-------------------------------------------------------------------+
                                  |
+-------------------------------------------------------------------+
|                    Operational Modules Layer                      |
|  Production (BOM, WIP, QC, Actual HPP) · Multi-Warehouse          |
|  Marketplace Excel Import + SKU Matching                          |
+-------------------------------------------------------------------+
```

---

## Navigation Group Structure (Filament Admin Panel)

```
🏢 Perusahaan
├── Perusahaan (Company settings)
├── Cabang (Branches)
└── Gudang (Warehouses)

👥 Master Data
├── Produk
├── Kategori
├── Kontak (Customer, Supplier, Employee, Other)
├── Bank & Kas
└── Aset Tetap

💰 Penjualan
├── Penawaran (Quotations)
├── Sales Order
├── Pengiriman
├── Faktur Penjualan
├── Pembayaran Customer
├── Retur Penjualan
└── Marketplace Import

🛒 Pembelian
├── Purchase Order
├── Penerimaan Barang
├── Faktur Pembelian
├── Pembayaran Supplier
└── Retur Pembelian

🏭 Produksi
├── Bill of Materials
├── Production Order
├── Work Order
├── Material Request
├── Material Issue
├── Output Produksi
├── Reject & Rework
└── Borongan

📊 Akuntansi
├── Chart of Accounts
├── Jurnal Umum
├── Jurnal Manual
├── General Ledger
├── Saldo Awal
├── Lock Period
└── Tutup Buku

📈 Laporan
├── Laba Rugi
├── Neraca
├── Cash Flow
├── Trial Balance
├── Laporan Penjualan
├── Laporan Pembelian
├── Laporan Inventory
└── Laporan Produksi

🔐 Approval & Audit
├── Approval List
├── Approval Rules
└── Audit Trail

⚙️ Pengaturan
├── Perusahaan
├── Akuntansi
├── Inventory
├── Penjualan
├── Pembelian
├── Produksi
├── Marketplace
├── Pajak
├── Nomor Transaksi
├── Notifikasi
└── Multi Currency

👤 Sistem
├── Users
├── Roles & Permissions
└── Backup

🏢 Backoffice (Superadmin Only)
├── Dashboard SaaS
├── Tenants
├── Subscription Plans
├── Subscriptions
├── Billing
├── Support Tickets
├── Announcements
├── Impersonation Log
└── Activity Log
```
