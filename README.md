<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="GoERP - Built with Laravel">
</p>

<h1 align="center">GoERP — SaaS ERP, Accounting, Inventory, Production & Marketplace</h1>

<p align="center">
  <a href="https://github.com/linducip2208/goerp"><img src="https://img.shields.io/github/stars/linducip2208/goerp?style=social" alt="Stars"></a>
  <img src="https://img.shields.io/badge/Laravel-11-red" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Filament-3.3-yellow" alt="Filament 3.3">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8-orange" alt="MySQL 8">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="MIT">
</p>

<p align="center">
  <b>🌍 Language / Bahasa / اللغة:</b><br>
  <a href="#-english">🇬🇧 English</a> ·
  <a href="#-bahasa-indonesia">🇮🇩 Indonesia</a> ·
  <a href="#-العربية-arabic">🇸🇦 العربية</a>
</p>

> **Contact / Kontak / الاتصال — Lindu Cipta**
> 📱 WhatsApp: **+62 812-9605-2010** — 👉 Chat now: **https://wa.me/6281296052010**
> _Need demo, installation, customization, or license? / Butuh demo, instalasi, kustomisasi, atau lisensi? / هل تحتاج إلى عرض تجريبي أو تثبيت أو تخصيص أو ترخيص؟ — Chat on WhatsApp._

---

<a id="-english"></a>
# 🇬🇧 English

## 1. What is GoERP?

**GoERP** is a **multi-tenant SaaS ERP** built for Indonesian businesses (and ready for global use). One installation serves hundreds of companies with strict data isolation per tenant.

It combines a **double-entry accounting core** with full operational modules: **Sales, Purchase, Inventory, Cash & Bank, Fixed Assets, Production, Marketplace Excel Import, Approval Workflow, Audit Trail, Reports (PDF/Excel), Customer Portal, Blog/SEO, and a SaaS Backoffice** (tenants, subscriptions, billing, support).

**Why GoERP vs Jurnal.id / Accurate / Mekari?**
- ✅ Production module: BOM + versioning, Work Orders, WIP, QC, Reject/Rework, Actual HPP, Borongan (piece-rate labor)
- ✅ Marketplace Excel import (Shopee / TikTok Shop / Lazada) with auto + manual + bulk SKU matching, duplicate protection, auto stock deduction
- ✅ Multi-tenant SaaS from day one: sell ERP as a subscription (Starter / Pro / Business / Enterprise)
- ✅ Backoffice: MRR dashboard, feature flags, package limits, impersonation, announcements, support tickets, backup/restore

**Codebase reality (verified):** 101 Eloquent models · 367 Filament admin files · 109 migrations · ~60+ business tables · Laravel 11 + Filament 3.3 + TailwindCSS + Sanctum-ready API + DomPDF + Laravel Excel.

## 2. Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11, PHP 8.2+ |
| Admin Panel | Filament 3.3 |
| Database | MySQL 8 |
| Public Frontend | Blade + TailwindCSS |
| API (Mobile / Integration) | Laravel Sanctum (token-based, JSON) |
| Queue | Redis + Horizon (production) |
| Search | Meilisearch (optional) |
| Storage | Local / S3-compatible (R2 / MinIO) |
| Export | barryvdh/laravel-dompdf (PDF), maatwebsite/excel (XLSX/CSV) |
| Mobile | Flutter (roadmap, API-ready) |

## 3. Architecture (3 Layers)

```
Layer 1 — SaaS Management: Tenant · Company · Branch · Subscription · Billing · Feature Flags · Backoffice
Layer 2 — Core ERP/Accounting: Sales · Purchase · Cash&Bank · Expense · Inventory · Accounting · Assets · Contacts · Reports
Layer 3 — Operational: Production · Multi-Warehouse · Marketplace Excel · SKU Matching · Customer Portal · Blog/SEO
```

**Golden rule:** every operational transaction auto-posts to the ledger. No standalone transaction without a journal.

```
Sales Invoice posted  → Dr Accounts Receivable / Cr Sales + Dr COGS / Cr Inventory
Payment received      → Dr Bank / Cr Accounts Receivable
Purchase Invoice      → Dr Inventory / Cr Accounts Payable
Supplier payment      → Dr Accounts Payable / Cr Bank
Material Issue        → Dr WIP / Cr Raw Material
Production Output     → Dr Finished Goods / Cr WIP
```

## 4. Complete Feature List (122+ features, 16 modules)

### A. SaaS & Multi-Tenant (6)
| # | Feature | Detail |
|---|---|---|
| A-1 | Multi-tenant architecture | One app, many customers. Tenant = data boundary |
| A-2 | Data isolation | Every record scoped by `tenant_id` (global scope + middleware) |
| A-3 | Login + subscription check | User → tenant → subscription status. Expired = view-only, renewable |
| A-4 | Multi-company | One tenant, N companies. Switcher in header |
| A-5 | Multi-branch | Branch with PIC, phone, address, default warehouse, active flag |
| A-6 | Roles & permissions | Owner, Finance, Accounting, Purchasing, Warehouse, Production, Sales, Auditor. Granular: View/Create/Edit/Delete/Approve/Export/Print per menu |

### B. Dashboard & Navigation (5)
| # | Feature | Detail |
|---|---|---|
| B-1 | Main dashboard | Cash, AR, AP, inventory cards, filter by company/branch/period |
| B-2 | Sales chart | Day/week/month/year + previous-period comparison (Chart.js) |
| B-3 | Cash-flow summary | Cash in / out / net |
| B-4 | Quick actions | +Invoice, +SO, +PO, +Expense, +Payment, +Product, +Contact |
| B-5 | Global search & notifications | Search invoice/PO/product/contact/journal; due-date, approval, low-stock, import-error notifications |

### C. Sales (9)
| # | Feature | Detail |
|---|---|---|
| C-1 | Full sales flow | Quotation → Sales Order → Delivery → Invoice → Payment → Return |
| C-2 | Sales Quotation | Expiry date, send/accept/reject, 1-click convert to SO |
| C-3 | Sales Order | Stock reservation, partial fulfillment, channel, salesperson |
| C-4 | Delivery (Surat Jalan) | Partial delivery, remaining-qty tracking |
| C-5 | Sales Invoice | Discount, tax, multi-warehouse/branch, due date, reference |
| C-6 | Invoice status | Draft → Open → Partial → Paid → Overdue → Void |
| C-7 | Customer payment | Full/partial, cash/transfer/giro, auto-updates AR |
| C-8 | Sales return | Stock-in + refund or credit note |
| C-9 | Auto-journal | Dr AR Cr Sales; Dr COGS Cr Inventory; Dr Bank Cr AR. PDF export per invoice |

### D. Purchase (7)
| # | Feature | Detail |
|---|---|---|
| D-1 | Full purchase flow | PO → Receipt → Invoice → Payment → Return |
| D-2 | Purchase Order | Approval workflow, expected delivery, payment terms |
| D-3 | Goods Receipt | Receive actual qty (≠ PO qty allowed), partial receiving |
| D-4 | Purchase Invoice | Supplier bill → AP, supplier invoice no., due date |
| D-5 | Supplier payment | Full/partial, auto-updates AP |
| D-6 | Purchase return | Stock-out + AP reduction / refund |
| D-7 | Auto-journal | Dr Inventory Cr AP; Dr AP Cr Bank. PDF export per PO |

### E. Product & Inventory (9)
| # | Feature | Detail |
|---|---|---|
| E-1 | Product master | SKU, barcode, category, brand, unit, cost/sell price, weight, dimensions, image, COA links |
| E-2 | Product variants | Color/size/attributes → each combination = unique internal SKU |
| E-3 | Internal SKU | Single source of truth for sales, purchase, stock, production, marketplace |
| E-4 | Multi-warehouse | Per-warehouse stock, branch-linked |
| E-5 | Stock balance | On Hand / Reserved / Available + average cost + last purchase cost |
| E-6 | Stock movement log | Immutable before/after log per SKU per warehouse |
| E-7 | Warehouse transfer | Draft → Approved → In Transit → Received |
| E-8 | Stock adjustment | In / Out / Lost / Damage / Reject / Correction / Return |
| E-9 | Stock opname | System vs physical → variance → approval → auto adjustment |

### F. Cash, Bank, Expense, Contacts (7)
| # | Feature | Detail |
|---|---|---|
| F-1 | Cash & bank accounts | Linked to COA, initial + current balance |
| F-2 | Receive money | Non-invoice cash-in with COA + contact + memo + attachment |
| F-3 | Send money | Cash-out to expense/asset account |
| F-4 | Inter-bank transfer | Transfer in/out between company accounts |
| F-5 | Bank reconciliation | Match system vs bank statement (reconciled flag + date) |
| F-6 | Expense | Category, department, branch, tax, bank source, attachment |
| F-7 | Contacts | Customer / Supplier / Employee / Other; NPWP, NIK, payment terms, credit limit |

### G. Accounting Core (7)
| # | Feature | Detail |
|---|---|---|
| G-1 | Chart of Accounts | Hierarchical: 1-Asset, 2-Liability, 3-Equity, 4-Revenue, 5-COGS, 6-Expense, 7-Other Income, 8-Other Expense |
| G-2 | Journal entries | Auto from transactions + manual; source_type/source_id traceability |
| G-3 | Manual journal | Debit = credit validation |
| G-4 | General ledger | Per-account mutation: opening → movements → closing balance |
| G-5 | Opening balance | Per account (+ AR/AP per contact) for migration |
| G-6 | Lock period | Block backdate edits in closed YYYY-MM periods |
| G-7 | Period closing | Checklist (bank reconciled, opname done, depreciation run, trial balance OK) → transfer P&L to retained earnings |

### H. Fixed Assets & Reports (8+)
| # | Feature | Detail |
|---|---|---|
| H-1 | Fixed assets | Register, category, acquisition cost/date, residual value, useful life, straight-line / double-declining, auto depreciation schedule + journal |
| H-2 | Profit & Loss | Gross → net profit, Chart.js visualization |
| H-3 | Balance Sheet | Assets = Liabilities + Equity |
| H-4 | Cash Flow | Operating / investing / financing |
| H-5 | Trial Balance | Debits = credits check |
| H-6 | Tax report | Per-tax-rate summary |
| H-7 | AR/AP aging | Overdue buckets per customer/supplier |
| H-8 | Sales reports | By product, customer, salesperson, channel, branch, date |
| H-9 | Purchase reports | By supplier, product, branch |
| H-10 | Inventory reports | Summary, detail, stock card, valuation, movement, low stock, negative stock |
| H-11 | Production reports | Output, variance, cost per unit |

### I. Approval & Audit (3)
| # | Feature | Detail |
|---|---|---|
| I-1 | Approval workflow | Draft → Submitted → Waiting → Approved → Posted / Rejected |
| I-2 | Approval rules | Multi-level by amount (e.g. <5M Supervisor, 5–50M Manager, >50M Owner) |
| I-3 | Audit trail | User, datetime, module, document type/no, old/new JSON, IP, user agent. Immutable, soft-delete only |

### J. Marketplace Excel Import (10)
| # | Feature | Detail |
|---|---|---|
| J-1 | No-API concept (V1) | Download Excel from Shopee/TikTok/Lazada → upload to GoERP |
| J-2 | Import wizard | Select marketplace + warehouse + upload XLSX/XLS/CSV |
| J-3 | Smart parsing | Order no, date, marketplace SKU, product, variant, qty, price, discount |
| J-4 | Auto SKU match | marketplace SKU = internal SKU → instant link |
| J-5 | Manual SKU match | Pick internal product, mapping saved for future imports |
| J-6 | Bulk matching UI | Resolve all unmatched SKUs at once |
| J-7 | Preview | Totals: orders, items, matched, unmatched, duplicates. Block import if unmatched remains |
| J-8 | Duplicate protection | Skip already-imported marketplace order/item IDs |
| J-9 | Auto stock deduction | Stock movement on internal SKU after import |
| J-10 | Import history | File, date, marketplace, counts, status (Uploaded/Matched/Previewed/Imported/Failed) |

### K. Production (13)
| # | Feature | Detail |
|---|---|---|
| K-1 | Production flow | BOM → Production Order → Material Request → Material Issue → WIP → Work Orders → Output/QC → Actual HPP |
| K-2 | BOM | Material qty per output unit, waste %, standard labor + overhead |
| K-3 | BOM versioning | Old orders keep their version |
| K-4 | Production Order | Target qty, BOM version, start/due dates, raw + finished warehouses |
| K-5 | Work Orders | Cutting → Sewing → Finishing → QC → Packing; team/operator, target/actual/reject/rework qty |
| K-6 | Material request | Production → warehouse request |
| K-7 | Material issue | Stock ↓, value → WIP (Dr WIP Cr Raw Material) |
| K-8 | WIP tracking | Goods in process before finished |
| K-9 | Material variance | Standard vs actual usage |
| K-10 | Output & QC | Good / Reject / Rework classification |
| K-11 | Reject & rework | Defect reasons (hole stitching, dirty, size, color, other) → reject warehouse |
| K-12 | Actual HPP | Total cost / good output per unit |
| K-13 | Borongan | Piece-rate labor per operation per operator → journal (Dr Production Labor Cr Bank/Cash) |

### L. Settings (12)
Company (logo, NPWP, NIB, address, timezone, fiscal year, currency) · Accounting defaults (AR/AP/inventory/sales/COGS/tax/retained earnings) · Inventory (costing, negative stock, multi-warehouse, alerts) · Sales/Purchase defaults (warehouse, tax, payment terms, credit limit, approval, over-receipt) · Production (raw/WIP/finished/reject warehouses, cost accounts) · Marketplace (require match, reduce stock, create SO/invoice/journal) · Transaction numbering (`INV/{YYYY}/{MM}/{####}` per doc type) · Tax rates (name, rate, inclusive/exclusive, COA) · Multi-currency + exchange rates · Attachments (PDF/JPG/PNG/XLSX) · Notifications (due, approval, low stock, import error).

### M. SaaS Backoffice — Platform Owner (16)
Dashboard (tenants, MRR, outstanding) · Tenant list/detail (companies, users, features, usage, billing, support) · 4 subscription plans (no code change) · Feature entitlement per plan · Package limits (users/companies/branches/warehouses/storage) · Status lifecycle (Trial → Active → Due → Grace → Suspended) · Expired handling (view-only, renewable, data kept) · Billing (invoice, payment, renewal, discount, coupon, tax) · Usage monitor · Per-tenant feature override · Impersonation / login-as-customer (fully logged) · Support tickets + replies · Announcements (all / plan / tenant) · Backup history/schedule/restore · Activity log.

### N. Extra built-in modules (beyond PRD — already in code)
| Module | What you get |
|---|---|
| Customer Portal | Separate login for customers: dashboard, invoice list/detail, payment history |
| CRM Lite | Leads, opportunities, activities |
| HR Lite | Employees, departments |
| Project & Budget | Projects, budgets vs actual |
| Cash Advance & Petty Cash | Advances, petty-cash ledger |
| POS Outlets, Promotions, Units, Brands, Currencies, Payment Methods | Retail-ready masters |
| Recurring Journals, Fiscal Periods, Workflow Rules, Integrations, API Keys | Automation-ready |
| Blog + Categories + Programmatic SEO + Sitemap + IndexNow | Built-in marketing/SEO engine |
| PDF + Excel everywhere | Invoice/PO PDFs, report exports |
| License Client (`routes/pair-routes.php`) | Pairing/license enforcement ready |

## 5. Subscription Plans

| Feature | Starter | Pro | Business | Enterprise |
|---|---|---|---|---|
| Accounting | ✅ | ✅ | ✅ | ✅ |
| Inventory | ✅ | ✅ | ✅ | ✅ |
| Multi-Warehouse | ❌ | ✅ | ✅ | ✅ |
| Approval | ❌ | ✅ | ✅ | ✅ |
| Marketplace Import | ❌ | ❌ | ✅ | ✅ |
| Production | ❌ | ❌ | ✅ | ✅ |
| Max Users | 3 | 10 | 25 | Unlimited |
| Max Companies | 1 | 3 | 10 | Unlimited |
| Max Branches / Warehouses | 1 / 1 | 5 / 5 | 20 / 20 | Unlimited |
| Support | Email | Priority Email | Chat + Email | Dedicated |

## 6. Quick Start

```bash
git clone https://github.com/linducip2208/goerp.git
cd goerp
composer install
cp .env.example .env
php artisan key:generate
# set DB_* in .env (MySQL 8), then:
php artisan migrate --seed
npm install && npm run build
php artisan serve
# Admin: /admin (Filament) · Portal: /portal · Blog: /blog · Docs: /docs
```

Requirements: PHP 8.2+, Composer, Node 18+, MySQL 8.

## 7. Roles

Owner · Finance · Accounting · Purchasing · Warehouse · Production · Sales · Auditor (read-only) · Superadmin (backoffice only).

## 8. Roadmap

- [x] Phase 1 — Core SaaS + Accounting (MVP)
- [x] Phase 2 — Operational control (multi-warehouse, opname, approval, audit, assets, lock, closing)
- [x] Phase 3 — Production (BOM, WIP, QC, HPP, borongan)
- [x] Phase 4 — Marketplace Excel (Shopee/TikTok/Lazada)
- [ ] Phase 5 — Marketplace API, customer portal v2, multi-currency++, budgeting++, AI forecasting (BYOK), Flutter mobile app

## 9. Contact (EN)

> **Lindu Cipta — GoERP Sales / Support / Custom Development**
> 📱 WhatsApp: **+62 812-9605-2010**
> 🔗 Direct chat: **https://wa.me/6281296052010**
> Please include your company name + needs (demo / install / custom / license) when chatting.

## 10. License

MIT — free for commercial use. See `LICENSE`.

---

<a id="-bahasa-indonesia"></a>
# 🇮🇩 Bahasa Indonesia

## 1. Apa itu GoERP?

**GoERP** adalah **ERP SaaS multi-tenant** untuk bisnis Indonesia. Satu instalasi melayani ratusan perusahaan dengan isolasi data ketat per tenant.

Menggabungkan **inti akuntansi double-entry** dengan modul operasional lengkap: **Penjualan, Pembelian, Inventory, Kas & Bank, Aset Tetap, Produksi, Import Excel Marketplace, Approval Workflow, Audit Trail, Laporan (PDF/Excel), Portal Customer, Blog/SEO, dan Backoffice SaaS** (tenant, langganan, billing, support).

**Kenapa GoERP dibanding Jurnal.id / Accurate / Mekari?**
- ✅ Modul produksi: BOM + versioning, Work Order, WIP, QC, Reject/Rework, HPP aktual, Borongan
- ✅ Import Excel marketplace (Shopee / TikTok Shop / Lazada) dengan SKU matching otomatis + manual + bulk, proteksi duplikat, pengurangan stok otomatis
- ✅ SaaS multi-tenant sejak hari pertama: jual ERP sebagai langganan (Starter / Pro / Business / Enterprise)
- ✅ Backoffice: dashboard MRR, feature flag, limit paket, impersonation, pengumuman, tiket support, backup/restore

**Kondisi kode (terverifikasi):** 101 model Eloquent · 367 file admin Filament · 109 migration · 60+ tabel bisnis · Laravel 11 + Filament 3.3 + TailwindCSS + API Sanctum + DomPDF + Laravel Excel.

## 2. Teknologi

| Lapisan | Teknologi |
|---|---|
| Backend | Laravel 11, PHP 8.2+ |
| Panel Admin | Filament 3.3 |
| Database | MySQL 8 |
| Frontend Publik | Blade + TailwindCSS |
| API (Mobile / Integrasi) | Laravel Sanctum (token, JSON) |
| Queue | Redis + Horizon (produksi) |
| Search | Meilisearch (opsional) |
| Storage | Lokal / S3-compatible (R2 / MinIO) |
| Export | barryvdh/laravel-dompdf (PDF), maatwebsite/excel (XLSX/CSV) |
| Mobile | Flutter (roadmap, API-ready) |

## 3. Arsitektur (3 Lapisan)

```
Lapisan 1 — Manajemen SaaS: Tenant · Perusahaan · Cabang · Langganan · Billing · Feature Flag · Backoffice
Lapisan 2 — ERP/Akuntansi Inti: Penjualan · Pembelian · Kas&Bank · Beban · Inventory · Akuntansi · Aset · Kontak · Laporan
Lapisan 3 — Operasional: Produksi · Multi-Gudang · Excel Marketplace · SKU Matching · Portal Customer · Blog/SEO
```

**Aturan emas:** setiap transaksi operasional otomatis menjurnal. Tidak ada transaksi tanpa jurnal.

```
Faktur Jual diposting → Dr Piutang / Cr Penjualan + Dr HPP / Cr Persediaan
Pembayaran diterima   → Dr Bank / Cr Piutang
Faktur Beli           → Dr Persediaan / Cr Hutang
Bayar supplier        → Dr Hutang / Cr Bank
Pengeluaran bahan     → Dr WIP / Cr Bahan Baku
Output produksi       → Dr Barang Jadi / Cr WIP
```

## 4. Daftar Fitur Lengkap (122+ fitur, 16 modul)

### A. SaaS & Multi-Tenant (6)
| # | Fitur | Detail |
|---|---|---|
| A-1 | Arsitektur multi-tenant | Satu aplikasi, banyak customer. Tenant = batas data |
| A-2 | Isolasi data | Setiap record punya `tenant_id` (global scope + middleware) |
| A-3 | Login + cek langganan | User → tenant → status langganan. Kedaluwarsa = view-only, bisa perpanjang |
| A-4 | Multi-perusahaan | Satu tenant, N perusahaan. Switcher di header |
| A-5 | Multi-cabang | Cabang + PIC, telepon, alamat, gudang default, status aktif |
| A-6 | Role & permission | Owner, Finance, Accounting, Purchasing, Gudang, Produksi, Sales, Auditor. Rinci: Lihat/Buat/Ubah/Hapus/Approve/Export/Cetak per menu |

### B. Dashboard & Navigasi (5)
| # | Fitur | Detail |
|---|---|---|
| B-1 | Dashboard utama | Kartu kas, piutang, hutang, inventory, filter perusahaan/cabang/periode |
| B-2 | Grafik penjualan | Harian/mingguan/bulanan/tahunan + perbandingan periode lalu (Chart.js) |
| B-3 | Ringkasan cash flow | Kas masuk / keluar / bersih |
| B-4 | Quick action | +Faktur, +SO, +PO, +Beban, +Pembayaran, +Produk, +Kontak |
| B-5 | Global search & notifikasi | Cari faktur/PO/produk/kontak/jurnal; notifikasi jatuh tempo, approval, stok menipis, error import |

### C. Penjualan (9)
| # | Fitur | Detail |
|---|---|---|
| C-1 | Alur penuh | Penawaran → SO → Pengiriman → Faktur → Pembayaran → Retur |
| C-2 | Penawaran (Quotation) | Tanggal kedaluwarsa, kirim/terima/tolak, 1-klik jadi SO |
| C-3 | Sales Order | Reservasi stok, partial fulfillment, channel, sales |
| C-4 | Pengiriman (Surat Jalan) | Parsial, tracking sisa qty |
| C-5 | Faktur Penjualan | Diskon, pajak, multi-gudang/cabang, jatuh tempo, referensi |
| C-6 | Status faktur | Draft → Open → Partial → Paid → Overdue → Void |
| C-7 | Pembayaran customer | Penuh/parsial, cash/transfer/giro, otomatis update piutang |
| C-8 | Retur penjualan | Stok masuk + refund atau nota kredit |
| C-9 | Jurnal otomatis | Dr Piutang Cr Penjualan; Dr HPP Cr Persediaan; Dr Bank Cr Piutang. Export PDF per faktur |

### D. Pembelian (7)
| # | Fitur | Detail |
|---|---|---|
| D-1 | Alur penuh | PO → Penerimaan → Faktur → Pembayaran → Retur |
| D-2 | Purchase Order | Approval workflow, estimasi kirim, termin bayar |
| D-3 | Penerimaan Barang | Qty terima aktual (boleh ≠ PO), parsial |
| D-4 | Faktur Pembelian | Tagihan supplier → hutang, no. faktur supplier, jatuh tempo |
| D-5 | Pembayaran supplier | Penuh/parsial, otomatis update hutang |
| D-6 | Retur pembelian | Stok keluar + pengurang hutang / refund |
| D-7 | Jurnal otomatis | Dr Persediaan Cr Hutang; Dr Hutang Cr Bank. Export PDF per PO |

### E. Produk & Inventory (9)
| # | Fitur | Detail |
|---|---|---|
| E-1 | Master produk | SKU, barcode, kategori, brand, satuan, harga beli/jual, berat, dimensi, foto, link COA |
| E-2 | Varian produk | Warna/ukuran/atribut → tiap kombinasi = SKU internal unik |
| E-3 | SKU internal | Satu-satunya sumber kebenaran untuk jual, beli, stok, produksi, marketplace |
| E-4 | Multi-gudang | Stok per gudang, terhubung ke cabang |
| E-5 | Saldo stok | On Hand / Reserved / Available + harga rata-rata + harga beli terakhir |
| E-6 | Log mutasi stok | Immutable before/after per SKU per gudang |
| E-7 | Transfer gudang | Draft → Approved → In Transit → Received |
| E-8 | Adjustment stok | Masuk / Keluar / Hilang / Rusak / Reject / Koreksi / Retur |
| E-9 | Stock opname | Sistem vs fisik → selisih → approval → adjustment otomatis |

### F. Kas, Bank, Beban, Kontak (7)
| # | Fitur | Detail |
|---|---|---|
| F-1 | Akun kas & bank | Terhubung COA, saldo awal + berjalan |
| F-2 | Terima uang | Kas masuk non-faktur + COA + kontak + memo + lampiran |
| F-3 | Kirim uang | Kas keluar ke akun beban/aset |
| F-4 | Transfer antar bank | Transfer masuk/keluar antar rekening perusahaan |
| F-5 | Rekonsiliasi bank | Cocokkan sistem vs mutasi bank (flag + tanggal rekonsiliasi) |
| F-6 | Beban | Kategori, departemen, cabang, pajak, sumber bank, lampiran |
| F-7 | Kontak | Customer / Supplier / Karyawan / Lainnya; NPWP, NIK, termin, limit kredit |

### G. Akuntansi Inti (7)
| # | Fitur | Detail |
|---|---|---|
| G-1 | Chart of Accounts | Hirarki: 1-Aset, 2-Kewajiban, 3-Ekuitas, 4-Pendapatan, 5-HPP, 6-Beban, 7-Pendapatan Lain, 8-Beban Lain |
| G-2 | Jurnal | Otomatis dari transaksi + manual; traceable via source_type/source_id |
| G-3 | Jurnal manual | Validasi debit = kredit |
| G-4 | Buku besar | Mutasi per akun: saldo awal → mutasi → saldo akhir |
| G-5 | Saldo awal | Per akun (+ piutang/hutang per kontak) untuk migrasi |
| G-6 | Lock period | Kunci periode YYYY-MM agar tidak bisa edit/backdate |
| G-7 | Tutup buku | Checklist (rekonsiliasi bank, opname, penyusutan, trial balance OK) → pindahkan laba rugi ke laba ditahan |

### H. Aset Tetap & Laporan (8+)
| # | Fitur | Detail |
|---|---|---|
| H-1 | Aset tetap | Register, kategori, biaya/tanggal perolehan, nilai residu, umur manfaat, garis lurus / saldo menurun, jadwal penyusutan + jurnal otomatis |
| H-2 | Laba Rugi | Laba kotor → bersih, visual Chart.js |
| H-3 | Neraca | Aset = Kewajiban + Ekuitas |
| H-4 | Arus Kas | Operasi / investasi / pendanaan |
| H-5 | Trial Balance | Cek debit = kredit |
| H-6 | Laporan pajak | Rekap per tarif pajak |
| H-7 | AR/AP aging | Bucket overdue per customer/supplier |
| H-8 | Laporan penjualan | Per produk, customer, sales, channel, cabang, tanggal |
| H-9 | Laporan pembelian | Per supplier, produk, cabang |
| H-10 | Laporan inventory | Ringkasan, detail, kartu stok, valuasi, mutasi, stok menipis, stok negatif |
| H-11 | Laporan produksi | Output, variansi, HPP per unit |

### I. Approval & Audit (3)
| # | Fitur | Detail |
|---|---|---|
| I-1 | Workflow approval | Draft → Submitted → Waiting → Approved → Posted / Rejected |
| I-2 | Aturan approval | Multi-level berdasar nominal (mis. <5jt Supervisor, 5–50jt Manager, >50jt Owner) |
| I-3 | Audit trail | User, waktu, modul, tipe/no dokumen, old/new JSON, IP, user agent. Immutable, hanya soft-delete |

### J. Import Excel Marketplace (10)
| # | Fitur | Detail |
|---|---|---|
| J-1 | Konsep tanpa API (V1) | Download Excel dari Shopee/TikTok/Lazada → upload ke GoERP |
| J-2 | Wizard import | Pilih marketplace + gudang + upload XLSX/XLS/CSV |
| J-3 | Parsing cerdas | No. order, tanggal, SKU marketplace, produk, varian, qty, harga, diskon |
| J-4 | Auto SKU match | SKU marketplace = SKU internal → langsung terhubung |
| J-5 | Manual SKU match | Pilih produk internal, mapping tersimpan untuk import berikutnya |
| J-6 | Bulk matching | Bereskan semua SKU yang belum match sekaligus |
| J-7 | Preview | Total: order, item, matched, unmatched, duplikat. Import diblokir jika masih ada unmatched |
| J-8 | Proteksi duplikat | Lewati order/item yang sudah pernah diimport |
| J-9 | Pengurangan stok otomatis | Mutasi stok SKU internal setelah import |
| J-10 | Riwayat import | File, tanggal, marketplace, jumlah, status (Uploaded/Matched/Previewed/Imported/Failed) |

### K. Produksi (13)
| # | Fitur | Detail |
|---|---|---|
| K-1 | Alur produksi | BOM → Production Order → Material Request → Material Issue → WIP → Work Order → Output/QC → HPP aktual |
| K-2 | BOM | Kebutuhan bahan per unit output, waste %, biaya tenaga + overhead standar |
| K-3 | Versioning BOM | Order lama tetap pakai versi lamanya |
| K-4 | Production Order | Target qty, versi BOM, tanggal mulai/selesai, gudang bahan + jadi |
| K-5 | Work Order | Cutting → Sewing → Finishing → QC → Packing; tim/operator, target/aktual/reject/rework qty |
| K-6 | Material request | Produksi → permintaan bahan ke gudang |
| K-7 | Material issue | Stok ↓, nilai → WIP (Dr WIP Cr Bahan Baku) |
| K-8 | WIP | Barang dalam proses sebelum jadi |
| K-9 | Variansi bahan | Standar vs aktual |
| K-10 | Output & QC | Klasifikasi Good / Reject / Rework |
| K-11 | Reject & rework | Alasan defect (jahitan bolong, kotor, ukuran, warna, lainnya) → gudang reject |
| K-12 | HPP aktual | Total biaya / output bagus per unit |
| K-13 | Borongan | Upah per operasi per operator → jurnal (Dr Beban Produksi Cr Bank/Kas) |

### L. Pengaturan (12)
Perusahaan (logo, NPWP, NIB, alamat, timezone, tahun fiskal, mata uang) · Default akuntansi (AR/AP/persediaan/penjualan/HPP/pajak/laba ditahan) · Inventory (metode costing, stok negatif, multi-gudang, alert) · Default penjualan/pembelian (gudang, pajak, termin, limit kredit, approval, over-receipt) · Produksi (gudang bahan/WIP/jadi/reject, akun biaya) · Marketplace (wajib match, kurangi stok, buat SO/faktur/jurnal) · Penomoran transaksi (`INV/{YYYY}/{MM}/{####}` per tipe) · Tarif pajak (nama, tarif, inclusive/exclusive, COA) · Multi-currency + kurs · Lampiran (PDF/JPG/PNG/XLSX) · Notifikasi (jatuh tempo, approval, stok menipis, error import).

### M. Backoffice SaaS — Pemilik Platform (16)
Dashboard (tenant, MRR, outstanding) · List/detail tenant (perusahaan, user, fitur, usage, billing, support) · 4 paket langganan (tanpa ubah kode) · Hak fitur per paket · Limit paket (user/perusahaan/cabang/gudang/storage) · Status (Trial → Active → Due → Grace → Suspended) · Tenant kedaluwarsa (view-only, bisa perpanjang, data aman) · Billing (faktur, pembayaran, renewal, diskon, kupon, pajak) · Monitor usage · Override fitur per tenant · Impersonation / login-sebagai-customer (tercatat) · Tiket support + balasan · Pengumuman (semua / paket / tenant) · Backup history/jadwal/restore · Activity log.

### N. Modul bonus (sudah ada di kode — di luar PRD)
| Modul | Isi |
|---|---|
| Portal Customer | Login terpisah untuk customer: dashboard, list/detail faktur, riwayat bayar |
| CRM Lite | Lead, opportunity, aktivitas |
| HR Lite | Karyawan, departemen |
| Project & Budget | Project, anggaran vs aktual |
| Kas Bon & Petty Cash | Uang muka, kas kecil |
| Outlet POS, Promosi, Satuan, Brand, Mata Uang, Metode Bayar | Master siap ritel |
| Jurnal Berulang, Periode Fiskal, Workflow Rule, Integrasi, API Key | Siap otomasi |
| Blog + Kategori + SEO Programatik + Sitemap + IndexNow | Mesin marketing/SEO bawaan |
| PDF + Excel di mana-mana | PDF faktur/PO, export laporan |
| License Client (`routes/pair-routes.php`) | Siap pairing/lisensi |

## 5. Paket Langganan

| Fitur | Starter | Pro | Business | Enterprise |
|---|---|---|---|---|
| Akuntansi | ✅ | ✅ | ✅ | ✅ |
| Inventory | ✅ | ✅ | ✅ | ✅ |
| Multi-Gudang | ❌ | ✅ | ✅ | ✅ |
| Approval | ❌ | ✅ | ✅ | ✅ |
| Import Marketplace | ❌ | ❌ | ✅ | ✅ |
| Produksi | ❌ | ❌ | ✅ | ✅ |
| Maks. User | 3 | 10 | 25 | Unlimited |
| Maks. Perusahaan | 1 | 3 | 10 | Unlimited |
| Maks. Cabang / Gudang | 1 / 1 | 5 / 5 | 20 / 20 | Unlimited |
| Support | Email | Email Prioritas | Chat + Email | Dedicated |

## 6. Cara Instal

```bash
git clone https://github.com/linducip2208/goerp.git
cd goerp
composer install
cp .env.example .env
php artisan key:generate
# isi DB_* di .env (MySQL 8), lalu:
php artisan migrate --seed
npm install && npm run build
php artisan serve
# Admin: /admin (Filament) · Portal: /portal · Blog: /blog · Docs: /docs
```

Kebutuhan: PHP 8.2+, Composer, Node 18+, MySQL 8.

## 7. Role

Owner · Finance · Accounting · Purchasing · Gudang · Produksi · Sales · Auditor (read-only) · Superadmin (khusus backoffice).

## 8. Roadmap

- [x] Fase 1 — SaaS + Akuntansi inti (MVP)
- [x] Fase 2 — Kontrol operasional (multi-gudang, opname, approval, audit, aset, lock, tutup buku)
- [x] Fase 3 — Produksi (BOM, WIP, QC, HPP, borongan)
- [x] Fase 4 — Marketplace Excel (Shopee/TikTok/Lazada)
- [ ] Fase 5 — API Marketplace, portal v2, multi-currency++, budgeting++, AI forecasting (BYOK), aplikasi Flutter

## 9. Kontak (ID)

> **Lindu Cipta — Penjualan / Support / Jasa Custom GoERP**
> 📱 WhatsApp: **+62 812-9605-2010**
> 🔗 Chat langsung: **https://wa.me/6281296052010**
> Sertakan nama perusahaan + kebutuhan (demo / instal / custom / lisensi) saat chat.

## 10. Lisensi

MIT — bebas untuk komersial. Lihat `LICENSE`.

---

<a id="-العربية-arabic"></a>
# 🇸🇦 العربية (Arabic)

## 1. ما هو GoERP؟

**GoERP** هو نظام **ERP سحابي متعدد المستأجرين (Multi-tenant SaaS)** مصمم للشركات الإندونيسية وجاهز للاستخدام العالمي. تثبيت واحد يخدم مئات الشركات مع عزل صارم للبيانات لكل مستأجر.

يجمع بين **نواة محاسبية بنظام القيد المزدوج** ووحدات تشغيلية كاملة: **المبيعات، المشتريات، المخزون، النقد والبنوك، الأصول الثابتة، الإنتاج، استيراد إكسل للمتاجر الإلكترونية، سير الموافقات، سجل التدقيق، التقارير (PDF/Excel)، بوابة العملاء، المدونة/SEO، ولوحة تحكم SaaS** (المستأجرون، الاشتراكات، الفوترة، الدعم).

**لماذا GoERP وليس Jurnal.id / Accurate / Mekari؟**
- ✅ وحدة الإنتاج: BOM + إصدارات، أوامر التشغيل، WIP، QC، المرفوض/إعادة العمل، تكلفة HPP الفعلية، أجور القطعة (Borongan)
- ✅ استيراد إكسل (Shopee / TikTok Shop / Lazada) مع مطابقة SKU تلقائية + يدوية + جماعية، حماية من التكرار، خصم تلقائي للمخزون
- ✅ SaaS متعدد المستأجرين من اليوم الأول: بِع الـ ERP كاشتراك (Starter / Pro / Business / Enterprise)
- ✅ لوحة المالك: لوحة MRR، أعلام الميزات، حدود الباقات، انتحال الدخول (Impersonation)، الإعلانات، تذاكر الدعم، النسخ الاحتياطي/الاستعادة

**واقع الكود (موثّق):** 101 موديل Eloquent · 367 ملف إدارة Filament · 109 هجرة (Migration) · +60 جدول أعمال · Laravel 11 + Filament 3.3 + TailwindCSS + API عبر Sanctum + DomPDF + Laravel Excel.

## 2. التقنيات

| الطبقة | التقنية |
|---|---|
| الخلفية | Laravel 11, PHP 8.2+ |
| لوحة الإدارة | Filament 3.3 |
| قاعدة البيانات | MySQL 8 |
| الواجهة العامة | Blade + TailwindCSS |
| API (جوال / تكامل) | Laravel Sanctum (توكن، JSON) |
| الطوابير | Redis + Horizon (للإنتاج) |
| البحث | Meilisearch (اختياري) |
| التخزين | محلي / متوافق مع S3 (R2 / MinIO) |
| التصدير | barryvdh/laravel-dompdf (PDF)، maatwebsite/excel (XLSX/CSV) |
| الجوال | Flutter (خارطة طريق، API جاهز) |

## 3. المعمارية (3 طبقات)

```
الطبقة 1 — إدارة SaaS: مستأجر · شركة · فرع · اشتراك · فوترة · أعلام ميزات · لوحة مالك
الطبقة 2 — ERP/محاسبة أساسية: مبيعات · مشتريات · نقد وبنوك · مصاريف · مخزون · محاسبة · أصول · جهات اتصال · تقارير
الطبقة 3 — تشغيلية: إنتاج · مخازن متعددة · إكسل المتاجر · مطابقة SKU · بوابة العملاء · مدونة/SEO
```

**القاعدة الذهبية:** كل معاملة تشغيلية تُرحَّل تلقائيًا إلى الدفتر. لا معاملة بدون قيد.

```
فاتورة بيع مرحّلة → مدين ذمم مدينة / دائن مبيعات + مدين COGS / دائن مخزون
قبض → مدين بنك / دائن ذمم مدينة
فاتورة شراء → مدين مخزون / دائن ذمم دائنة
دفع لمورّد → مدين ذمم دائنة / دائن بنك
صرف مواد → مدين WIP / دائن مواد خام
مخرجات إنتاج → مدين بضاعة تامة / دائن WIP
```

## 4. قائمة الميزات الكاملة (122+ ميزة، 16 وحدة)

### أ. SaaS وتعدد المستأجرين (6)
| # | الميزة | التفاصيل |
|---|---|---|
| A-1 | معمارية متعددة المستأجرين | تطبيق واحد، عملاء كثيرون. المستأجر = حد البيانات |
| A-2 | عزل البيانات | كل سجل فيه `tenant_id` (نطاق عام + وسيط) |
| A-3 | تسجيل الدخول + فحص الاشتراك | مستخدم ← مستأجر ← حالة الاشتراك. المنتهي = عرض فقط، قابل للتجديد |
| A-4 | شركات متعددة | مستأجر واحد، N شركات. مبدّل في الأعلى |
| A-5 | فروع متعددة | فرع + مسؤول + هاتف + عنوان + مخزن افتراضي + حالة |
| A-6 | الأدوار والصلاحيات | مالك، مالية، محاسبة، مشتريات، مخزن، إنتاج، مبيعات، مدقق. دقيقة: عرض/إنشاء/تعديل/حذف/اعتماد/تصدير/طباعة لكل قائمة |

### ب. لوحة القيادة والتنقل (5)
لوحة رئيسية (نقد، ذمم مدينة/دائنة، مخزون، فلترة) · رسم المبيعات (يومي/أسبوعي/شهري/سنوي + مقارنة، Chart.js) · ملخص التدفق النقدي (داخل/خارج/صافي) · إجراءات سريعة (+فاتورة، +SO، +PO، +مصروف، +دفع، +منتج، +جهة) · بحث شامل + تنبيهات (استحقاق، اعتماد، مخزون منخفض، خطأ استيراد).

### ج. المبيعات (9)
التدفق الكامل: عرض سعر ← أمر بيع ← تسليم ← فاتورة ← دفع ← مرتجع · عروض الأسعار (انتهاء، إرسال/قبول/رفض، تحويل بضغطة إلى SO) · أوامر البيع (حجز مخزون، تنفيذ جزئي، قناة، مندوب) · التسليم (جزئي، تتبع المتبقي) · الفواتير (خصم، ضريبة، مخازن/فروع، استحقاق) · الحالات: Draft ← Open ← Partial ← Paid ← Overdue ← Void · دفع العملاء (كامل/جزئي، نقدي/تحويل/شيك، تحديث تلقائي للذمم) · المرتجعات (دخول مخزني + استرداد أو إشعار دائن) · قيود تلقائية + تصدير PDF لكل فاتورة.

### د. المشتريات (7)
التدفق الكامل: PO ← استلام ← فاتورة ← دفع ← مرتجع · أوامر الشراء (اعتماد، تسليم متوقع، شروط دفع) · الاستلام (كمية فعلية، جزئي) · فواتير الموردين (← ذمم دائنة) · الدفع (كامل/جزئي) · المرتجعات (خروج مخزني + تخفيض ذمم/استرداد) · قيود تلقائية + PDF لكل PO.

### هـ. المنتجات والمخزون (9)
ملف المنتج (SKU، باركود، فئة، علامة، وحدة، سعر شراء/بيع، وزن، أبعاد، صورة، ربط COA) · المتغيرات (لون/مقاس/خصائص ← كل تركيبة = SKU داخلي فريد) · SKU الداخلي مرجع وحيد لكل الوحدات · مخازن متعددة (مخزون لكل مخزن، مرتبط بالفرع) · الأرصدة (متاح/محجوز/صافي + متوسط التكلفة + آخر شراء) · سجل حركة غير قابل للتعديل (قبل/بعد) · تحويلات (Draft ← Approved ← In Transit ← Received) · تسويات (داخل/خارج/مفقود/تالف/مرفوض/تصحيح/مرتجع) · الجرد الفعلي (نظام مقابل فعلي ← فرق ← اعتماد ← تسوية تلقائية).

### و. النقد والبنوك والمصاريف وجهات الاتصال (7)
حسابات نقد وبنوك (مرتبطة بـ COA، رصيد أولي + حالي) · قبض (غير فواتير + COA + جهة + مذكرة + مرفق) · صرف (إلى حساب مصروف/أصل) · تحويل بين البنوك · تسوية بنكية (مطابقة + تاريخ) · المصاريف (فئة، قسم، فرع، ضريبة، بنك، مرفق) · جهات الاتصال (عميل/مورد/موظف/أخرى؛ NPWP، NIK، شروط دفع، حد ائتماني).

### ز. المحاسبة الأساسية (7)
دليل الحسابات هرمي: 1-أصول، 2-التزامات، 3-حقوق، 4-إيرادات، 5-COGS، 6-مصاريف، 7-إيرادات أخرى، 8-مصاريف أخرى · قيود (تلقائية + يدوية؛ تتبع source_type/source_id) · قيد يدوي (مدين = دائن) · دفتر الأستاذ (أولي ← حركات ← ختامي) · أرصدة افتتاحية (لكل حساب + ذمم لكل جهة) · قفل الفترات (منع التعديل بأثر رجعي YYYY-MM) · إقفال الفترة (تشيك ليست: تسوية بنكية، جرد، إهلاك، ميزان OK ← ترحيل الأرباح إلى المحتجزة).

### ح. الأصول والتقارير (8+)
الأصول الثابتة (سجل، فئة، تكلفة/تاريخ اقتناء، خردة، عمر، قسط ثابت/متناقص، جدول إهلاك + قيد تلقائي) · الأرباح والخسائر (إجمالي ← صافي، Chart.js) · الميزانية (أصول = التزامات + حقوق) · التدفق النقدي (تشغيلي/استثماري/تمويلي) · ميزان المراجعة (مدين = دائن) · تقرير الضرائب · أعمار الذمم (متأخرات لكل عميل/مورد) · تقارير المبيعات (منتج، عميل، مندوب، قناة، فرع، تاريخ) · تقارير المشتريات · تقارير المخزون (ملخص، تفصيلي، بطاقة صنف، تقييم، حركة، منخفض، سالب) · تقارير الإنتاج (مخرجات، فروقات، تكلفة الوحدة).

### ط. الاعتماد والتدقيق (3)
سير الاعتماد: Draft ← Submitted ← Waiting ← Approved ← Posted / Rejected · قواعد متعددة حسب المبلغ (مثال: <5M مشرف، 5–50M مدير، >50M مالك) · سجل تدقيق: مستخدم، وقت، وحدة، نوع/رقم المستند، قيم قديمة/جديدة JSON، IP، جهاز. غير قابل للتعديل، حذف ناعم فقط.

### ي. استيراد إكسل المتاجر (10)
بدون API (V1): حمّل إكسل من Shopee/TikTok/Lazada ← ارفع إلى GoERP · معالج (متجر + مخزن + XLSX/XLS/CSV) · تحليل ذكي (رقم الطلب، تاريخ، SKU المتجر، منتج، متغير، كمية، سعر، خصم) · مطابقة تلقائية (SKU المتجر = الداخلي ← ربط فوري) · يدوية (اختر منتجًا، يُحفظ للمستقبل) · جماعية (حل كل غير المطابق دفعة واحدة) · معاينة (إجمالي: طلبات، أصناف، مطابق، غير مطابق، مكرر. يُمنع الاستيراد عند وجود غير مطابق) · حماية من التكرار (تخطي المستورد سابقًا) · خصم تلقائي للمخزون · سجل الاستيرادات (ملف، تاريخ، متجر، أعداد، حالة).

### ك. الإنتاج (13)
التدفق: BOM ← أمر إنتاج ← طلب مواد ← صرف ← WIP ← أوامر تشغيل ← مخرجات/QC ← HPP فعلية · BOM (مواد لكل وحدة، هالك %، أجور ومعايير) · إصدارات BOM (الطلبات القديمة تحتفظ بنسختها) · أمر الإنتاج (كمية مستهدفة، نسخة BOM، تواريخ، مخزن خام + تام) · أوامر التشغيل: قص ← خياطة ← تشطيب ← QC ← تغليف؛ فريق/عامل، مستهدف/فعلي/مرفوض/معاد · طلب المواد (إنتاج ← مخزن) · الصرف (مخزون ↓، القيمة ← WIP) · تتبع WIP · فروقات المواد (معياري مقابل فعلي) · المخرجات وQC (سليم/مرفوض/معاد) · المرفوض والمعاد (أسباب: خياطة مثقوبة، متسخ، مقاس، لون، أخرى ← مخزن مرفوضات) · HPP الفعلية (إجمالي/سليم لكل وحدة) · أجور القطعة (لكل عملية لكل عامل ← قيد).

### ل. الإعدادات (12)
الشركة (شعار، NPWP، NIB، عنوان، منطقة، سنة مالية، عملة) · افتراضات المحاسبة (ذمم مدينة/دائنة/مخزون/مبيعات/COGS/ضرائب/محتجزة) · المخزون (تكلفة، سالب، متعدد، تنبيهات) · افتراضات البيع/الشراء (مخزن، ضريبة، شروط، حد، اعتماد، استلام زائد) · الإنتاج (مخازن خام/WIP/تام/مرفوض، حسابات) · المتاجر (إلزام المطابقة، خصم مخزون، إنشاء SO/فاتورة/قيد) · ترقيم (`INV/{YYYY}/{MM}/{####}` لكل نوع) · ضرائب (اسم، نسبة، شامل/غير، COA) · عملات + أسعار صرف · مرفقات (PDF/JPG/PNG/XLSX) · تنبيهات (استحقاق، اعتماد، منخفض، خطأ).

### م. لوحة المالك SaaS (16)
لوحة (مستأجرون، MRR، مستحق) · قائمة/تفاصيل المستأجرين (شركات، مستخدمون، ميزات، استخدام، فوترة، دعم) · 4 باقات (بدون كود) · استحقاق الميزات لكل باقة · حدود (مستخدمون/شركات/فروع/مخازن/تخزين) · الحالات (Trial ← Active ← Due ← Grace ← Suspended) · المنتهي (عرض فقط، تجديد، بيانات محفوظة) · فوترة (فاتورة، دفع، تجديد، خصم، كوبون، ضريبة) · مراقبة الاستخدام · تجاوز الميزات لكل مستأجر · انتحال الدخول (مسجَّل) · تذاكر + ردود · إعلانات (كل/باقة/مستأجر) · نسخ احتياطي/جدولة/استعادة · سجل الأنشطة.

### ن. وحدات إضافية (موجودة فعلًا في الكود)
| الوحدة | المحتوى |
|---|---|
| بوابة العملاء | دخول منفصل: لوحة، فواتير/تفاصيل، مدفوعات |
| CRM خفيف | عملاء محتملون، فرص، أنشطة |
| HR خفيف | موظفون، أقسام |
| مشاريع وموازنات | مشاريع، فعلي مقابل موازنة |
| سلف ونثرية | سلف، صندوق نثري |
| منافذ POS، عروض، وحدات، علامات، عملات، طرق دفع | جاهز للتجزئة |
| قيود متكررة، فترات مالية، قواعد سير، تكاملات، مفاتيح API | جاهز للأتمتة |
| مدونة + فئات + SEO برمجي + خريطة + IndexNow | محرك تسويق مدمج |
| PDF + Excel في كل مكان | PDFs للفواتير/PO، تصدير تقارير |
| عميل الترخيص | جاهز للربط/الترخيص |

## 5. باقات الاشتراك

| الميزة | Starter | Pro | Business | Enterprise |
|---|---|---|---|---|
| محاسبة | ✅ | ✅ | ✅ | ✅ |
| مخزون | ✅ | ✅ | ✅ | ✅ |
| مخازن متعددة | ❌ | ✅ | ✅ | ✅ |
| اعتماد | ❌ | ✅ | ✅ | ✅ |
| استيراد المتاجر | ❌ | ❌ | ✅ | ✅ |
| إنتاج | ❌ | ❌ | ✅ | ✅ |
| حد المستخدمين | 3 | 10 | 25 | غير محدود |
| حد الشركات | 1 | 3 | 10 | غير محدود |
| حد الفروع / المخازن | 1 / 1 | 5 / 5 | 20 / 20 | غير محدود |
| الدعم | بريد | بريد مميز | محادثة + بريد | مخصص |

## 6. التثبيت السريع

```bash
git clone https://github.com/linducip2208/goerp.git
cd goerp
composer install
cp .env.example .env
php artisan key:generate
# اضبط DB_* في .env (MySQL 8)، ثم:
php artisan migrate --seed
npm install && npm run build
php artisan serve
# الإدارة: /admin (Filament) · البوابة: /portal · المدونة: /blog · المستندات: /docs
```

المتطلبات: PHP 8.2+، Composer، Node 18+، MySQL 8.

## 7. الأدوار

مالك · مالية · محاسبة · مشتريات · مخزن · إنتاج · مبيعات · مدقق (قراءة فقط) · مشرف عام (للمالك فقط).

## 8. خارطة الطريق

- [x] المرحلة 1 — SaaS + محاسبة (MVP)
- [x] المرحلة 2 — ضبط تشغيلي (مخازن، جرد، اعتماد، تدقيق، أصول، قفل، إقفال)
- [x] المرحلة 3 — الإنتاج (BOM، WIP، QC، HPP، قطع)
- [x] المرحلة 4 — إكسل المتاجر (Shopee/TikTok/Lazada)
- [ ] المرحلة 5 — API المتاجر، بوابة v2، عملات++، موازنات++، توقعات AI (BYOK)، تطبيق Flutter

## 9. الاتصال (AR)

> **ليندو تشيبتا — مبيعات / دعم / تطوير مخصص GoERP**
> 📱 واتساب: **+62 812-9605-2010**
> 🔗 محادثة مباشرة: **https://wa.me/6281296052010**
> اذكر اسم شركتك + احتياجك (تجربة / تثبيت / تخصيص / ترخيص) عند المراسلة.

## 10. الترخيص

MIT — مجاني للاستخدام التجاري. راجع `LICENSE`.

---

## 📞 Contact — Kontak — الاتصال

| | |
|---|---|
| 👤 Name / Nama / الاسم | **Lindu Cipta** |
| 📱 WhatsApp | **+62 812-9605-2010** |
| 💬 Chat / Chat / محادثة | **https://wa.me/6281296052010** |
| 🐙 GitHub | **https://github.com/linducip2208/goerp** |

<a href="https://wa.me/6281296052010"><img src="https://img.shields.io/badge/Chat_on_WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white" alt="Chat on WhatsApp"></a>
