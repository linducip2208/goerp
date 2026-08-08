# GoERP — Product Requirements Document (PRD)

**Version:** 1.0  
**Date:** August 2026  
**Product:** GoERP — SaaS ERP Accounting, Inventory, Production & Marketplace  

---

## Executive Summary

GoERP is a **multi-tenant SaaS ERP** designed for Indonesian businesses. It provides a complete accounting core (double-entry bookkeeping) connected to operational modules: sales, purchase, inventory, production, and marketplace order management via Excel import. The platform is sold on a subscription basis with 4 tiers: Starter, Pro, Business, Enterprise.

**Core differentiation from competitors (Jurnal.id, Accurate, Mekari):**
- Production module (BOM, WIP, QC, borongan, actual HPP)
- Marketplace Excel import with automatic SKU matching
- Multi-tenant SaaS from day-1 — sell to multiple companies
- Backoffice for platform owner to manage tenants, subscriptions, and feature flags

---

## Target Users

| Persona | Needs |
|---------|-------|
| **Business Owner** | Dashboard snapshot, financial reports, multi-branch visibility |
| **Finance Manager** | Cash flow, AR/AP aging, P&L, balance sheet, budget vs actual |
| **Accountant** | COA, journal entries, general ledger, closing, tax |
| **Purchasing Staff** | Purchase orders, goods receipt, supplier invoices, payment tracking |
| **Warehouse Staff** | Stock balance, inbound/outbound, transfers, stock opname |
| **Production Manager** | BOM, production orders, work orders, QC, actual HPP |
| **Sales Admin** | Quotations, sales orders, delivery, invoicing, marketplace imports |
| **Platform Owner** | Tenant management, subscription, billing, feature control, support |
| **Auditor** | Read-only access to all data, audit trail review |

---

## Product Goals

### Phase 1: Core SaaS + Accounting (MVP)
- Multi-tenant architecture with data isolation
- Backoffice for platform owner
- Subscription management (4 plans)
- Dashboard with sales chart, cash flow, quick actions
- Sales module: quotation → SO → delivery → invoice → payment → journal
- Purchase module: PO → receipt → invoice → payment → journal
- Cash & Bank: receive money, send money, transfer, reconciliation
- Expense tracking
- Product master with variants and internal SKU
- Basic inventory: stock balance, movement, transfers, warehouse
- Contacts: customers, suppliers, employees
- Full accounting: COA, journal, general ledger, trial balance, opening balance
- Financial reports: P&L, balance sheet, cash flow
- User management with roles & permissions
- Settings: company, accounting defaults, transaction number format

### Phase 2: Operational Control
- Multi-warehouse with per-warehouse stock tracking
- Stock opname (system vs physical, approval workflow)
- Approval workflow for transactions (multi-level, amount-based)
- Audit trail for all mutations
- Fixed asset management with depreciation schedule
- Lock period (prevent backdate edits)
- Period closing (auto transfer P&L to retained earnings)
- Advanced reports: sales by X, purchase by Y, inventory valuation

### Phase 3: Production
- Bill of Materials (BOM) with versioning
- Production orders with target qty, due dates
- Work orders (cutting → sewing → finishing → QC → packing)
- Material request & material issue (raw material → WIP)
- Work In Progress (WIP) tracking
- Material variance (standard vs actual usage)
- Production output: good / reject / rework classification
- Reject & rework tracking with defect reasons
- Production cost calculation → actual HPP per unit
- Borongan (piece rate) labor calculation
- Production reports

### Phase 4: Marketplace Excel
- Import orders from Shopee / TikTok Shop / Lazada Excel
- Automatic SKU matching (marketplace SKU → internal SKU)
- Manual SKU matching with saved mapping
- Bulk SKU matching interface
- Preview import before commit
- Duplicate protection (prevent double-import, double-stock-deduction)
- Automatic stock deduction after import
- Import history log

### Phase 5: Advanced (Future)
- Marketplace API integration (Shopee, TikTok, Lazada)
- Customer self-service portal
- Multi-currency support
- Advanced budgeting module
- AI-powered forecasting (BYOK — user's own AI provider)
- Mobile app (Flutter)

---

## Functional Requirements by Module

### A. SaaS & Multi-Tenant (6 sections)
| ID | Requirement |
|----|-------------|
| A-1 | Multi-tenant: one app serves multiple customers |
| A-2 | Data isolation: every record has `tenant_id` |
| A-3 | Login validates user, tenant, subscription status |
| A-4 | Multi-company: one tenant can have multiple companies |
| A-5 | Multi-branch: company can have branches with PIC, warehouse, status |
| A-6 | Role-based permissions: View, Create, Edit, Delete, Approve, Export, Print |

### B. Dashboard (5 sections)
| ID | Requirement |
|----|-------------|
| B-1 | Main dashboard: cash, AR, AP, inventory summary cards |
| B-2 | Sales chart with day/week/month/year filter and previous period comparison |
| B-3 | Cash flow summary: cash in, cash out, net |
| B-4 | Quick action buttons for frequent transactions |
| B-5 | Global search (invoice, PO, product, contact, journal) + notification |

### C. Sales (9 sections)
| ID | Requirement |
|----|-------------|
| C-1 | Sales flow: Quotation → SO → Delivery → Invoice → Payment |
| C-2 | Quotation with convert-to-SO |
| C-3 | Sales Order with reserve stock, partial fulfillment |
| C-4 | Delivery (goods out) with partial delivery support |
| C-5 | Sales Invoice as primary billing document |
| C-6 | Invoice status: Draft → Open → Partial → Paid → Overdue |
| C-7 | Customer payment (full/partial) updates AR |
| C-8 | Sales return: stock in + refund/credit |
| C-9 | Auto journal: Dr AR Cr Sales, Dr COGS Cr Inventory, Dr Bank Cr AR |

### D. Purchase (7 sections)
| ID | Requirement |
|----|-------------|
| D-1 | Purchase flow: PO → Receipt → Invoice → Payment |
| D-2 | Purchase Order with approval workflow |
| D-3 | Goods receipt (stock in) with partial receiving |
| D-4 | Purchase invoice forms AP |
| D-5 | Supplier payment (full/partial) updates AP |
| D-6 | Purchase return: stock out + AP reduction/refund |
| D-7 | Auto journal: Dr Inventory Cr AP, Dr AP Cr Bank |

### E. Product & Inventory (9 sections)
| ID | Requirement |
|----|-------------|
| E-1 | Product master with SKU, barcode, category, brand, unit, cost/sell price |
| E-2 | Product variants (color, size) → each combination = unique SKU |
| E-3 | Internal SKU as master ID for all modules |
| E-4 | Multi-warehouse with per-warehouse stock |
| E-5 | Stock balance: On Hand / Reserved / Available |
| E-6 | Stock movement log (every change tracked) |
| E-7 | Warehouse transfer with approval |
| E-8 | Stock adjustment (in/out/lost/damage/reject/correction) |
| E-9 | Stock opname: system vs physical → approval → adjustment |

### F. Cash, Bank, Expense, Contacts (7 sections)
| ID | Requirement |
|----|-------------|
| F-1 | Cash & bank accounts with receive/send/transfer |
| F-2 | Receive money (not from invoice) |
| F-3 | Send money (cash out to expense/asset account) |
| F-4 | Inter-bank transfer |
| F-5 | Bank reconciliation (system vs bank statement) |
| F-6 | Expense tracking by category, department, branch |
| F-7 | Contacts: customer, supplier, employee, other |

### G. Accounting Core (7 sections)
| ID | Requirement |
|----|-------------|
| G-1 | Chart of Accounts (COA) — hierarchical |
| G-2 | Journal entries (from transactions + manual) |
| G-3 | Manual journal with debit = credit validation |
| G-4 | General ledger per account |
| G-5 | Opening balance entry |
| G-6 | Lock period: prevent edits/backdate in locked periods |
| G-7 | Period closing: reconcile → close → transfer P&L to retained earnings |

### H. Fixed Assets & Reports (8 sections)
| ID | Requirement |
|----|-------------|
| H-1 | Fixed asset register with depreciation schedule |
| H-2 | Profit & Loss report |
| H-3 | Balance Sheet |
| H-4 | Cash Flow statement |
| H-5 | Trial Balance |
| H-6 | Sales reports (by product, customer, salesperson, channel, branch) |
| H-7 | Purchase reports (by supplier, product, branch) |
| H-8 | Inventory reports (stock summary, movement, valuation, low stock) |

### I. Approval & Audit (3 sections)
| ID | Requirement |
|----|-------------|
| I-1 | Approval workflow: Draft → Submitted → Waiting → Approved → Posted / Rejected |
| I-2 | Approval rules: multi-level based on amount (e.g., <5M: Supervisor, 5-50M: Manager, >50M: Owner) |
| I-3 | Audit trail: user, datetime, module, document, old/new value, IP, device |

### J. Marketplace Excel (10 sections)
| ID | Requirement |
|----|-------------|
| J-1 | Download → Upload Excel → Read → Check Duplicate → Match SKU → Preview → Import |
| J-2 | Import orders: select marketplace, warehouse, upload XLSX/XLS/CSV |
| J-3 | Read fields: order no, date, marketplace SKU, product, variant, qty, price |
| J-4 | Auto SKU match: marketplace SKU = internal SKU |
| J-5 | Manual SKU match: select internal product, save mapping for future imports |
| J-6 | Bulk SKU matching interface |
| J-7 | Preview: total orders, items, matched, unmatched, duplicates |
| J-8 | Block import if unmatched SKU exists |
| J-9 | Duplicate protection: check DB, skip if exists |
| J-10 | Auto stock deduction after successful import |

### K. Production (13 sections)
| ID | Requirement |
|----|-------------|
| K-1 | BOM defines material requirements per production unit |
| K-2 | BOM versioning (old POs use selected version) |
| K-3 | Production Order: product, target qty, BOM version, dates |
| K-4 | Work Orders: cutting, sewing, finishing, QC, packing with team/operator |
| K-5 | Material request from production to warehouse |
| K-6 | Material issue: raw material stock decreases, value moves to WIP |
| K-7 | WIP (Work In Progress) tracking |
| K-8 | Material variance: standard vs actual |
| K-9 | Production output: good, reject, rework |
| K-10 | Reject & rework with defect reasons |
| K-11 | Production cost calculation → actual HPP |
| K-12 | Borongan (piece rate) labor |
| K-13 | Production reports |

### L. Settings (12 sections)
| ID | Requirement |
|----|-------------|
| L-1 | Company settings: logo, name, NPWP, NIB, address, timezone, fiscal year, currency |
| L-2 | Accounting defaults: AR, AP, inventory, sales, COGS, tax accounts |
| L-3 | Inventory settings: costing method, negative stock, multi-warehouse |
| L-4 | Sales settings: default warehouse, tax, payment term, credit limit |
| L-5 | Purchase settings: default warehouse, tax, approval |
| L-6 | Production settings: warehouse accounts, WIP/finished/reject warehouse |
| L-7 | Marketplace settings: require SKU match, reduce stock, create SO |
| L-8 | Transaction number format: configurable per document type |
| L-9 | Tax settings: name, rate, type, inclusive/exclusive, account |
| L-10 | Multi-currency with exchange rate |
| L-11 | Attachment support: PDF, JPG, PNG, XLSX |
| L-12 | Notification: due date, approval, low stock, import error |

### M. SaaS Backoffice (16 sections)
| ID | Requirement |
|----|-------------|
| M-1 | Backoffice dashboard: tenant count, MRR, outstanding |
| M-2 | Tenant list with customer, package, status |
| M-3 | Tenant detail: companies, subscription, users, features, usage |
| M-4 | Subscription plan management (4 tiers) |
| M-5 | Feature entitlement per plan |
| M-6 | Package limits: max users, companies, branches, warehouses |
| M-7 | Subscription status: Trial → Active → Due → Grace → Suspended |
| M-8 | Expired tenant: view-only, can renew |
| M-9 | Billing: invoice, payment, renewal, discount, coupon, tax |
| M-10 | Usage monitor: users, companies, products, transactions |
| M-11 | Feature control per tenant (toggle on/off) |
| M-12 | Login as customer / impersonation (logged) |
| M-13 | Support ticket system |
| M-14 | Announcements to all/specific tenants |
| M-15 | Database backup with history and restore |
| M-16 | Activity log |

---

## Non-Functional Requirements

| Category | Requirement |
|----------|-------------|
| Performance | Dashboard loads < 2s, report generation < 5s (up to 100K records) |
| Scalability | Support 1000+ tenants, 1M+ products, 10M+ transactions |
| Security | All data encrypted at rest (keys, secrets), TLS for transit, tenant data isolation |
| Availability | 99.5% uptime, scheduled maintenance window |
| Backup | Automated daily backup, 30-day retention, restore capability |
| Audit | Immutable audit trail, no delete — only soft delete |
| Responsive | Admin panel responsive for tablet/mobile (720p+) |
| Localization | Bahasa Indonesia primary, with i18n support for future |

---

## Subscription Plans

| Feature | Starter | Pro | Business | Enterprise |
|---------|---------|-----|----------|------------|
| Accounting | Yes | Yes | Yes | Yes |
| Inventory | Yes | Yes | Yes | Yes |
| Multi-Warehouse | No | Yes | Yes | Yes |
| Marketplace Import | No | No | Yes | Yes |
| Production | No | No | Yes | Yes |
| Approval | No | Yes | Yes | Yes |
| Max Users | 3 | 10 | 25 | Unlimited |
| Max Companies | 1 | 3 | 10 | Unlimited |
| Max Branches | 1 | 5 | 20 | Unlimited |
| Max Warehouses | 1 | 5 | 20 | Unlimited |
| Support | Email | Priority Email | Chat + Email | Dedicated |
