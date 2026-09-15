<p align="center">
  <h1 align="center">GoERP — SaaS ERP Accounting, Inventory, Production & Marketplace</h1>
  <p align="center">Laravel 11 + Filament 3.3 + MySQL 8 · Multi-Tenant SaaS · 101 Models · 109 Migrations · 75+ Filament Resources</p>
</p>

<p align="center">
  <a href="https://github.com/linducip2208/goerp"><img src="https://img.shields.io/github/stars/linducip2208/goerp?style=social" alt="Stars"></a>
  <img src="https://img.shields.io/badge/Laravel-11-red" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Filament-3.3-yellow" alt="Filament 3.3">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange" alt="MySQL">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
</p>

> **Contact / Kontak / اتصل بنا:**
> **Lindu Cipta — WhatsApp: [+6281296052010](https://wa.me/6281296052010)**
> Click to chat → https://wa.me/6281296052010

---

## 🌐 Language / Bahasa / اللغة

- [1. English](#1--english)
- [2. Bahasa Indonesia](#2--bahasa-indonesia)
- [3. العربية (Arabic)](#3--العربية-arabic)
- [Subscription Plans (all languages)](#-subscription-plans--paket-harga--خطط-الاشتراك)
- [Installation](#-installation--instalasi--التثبيت)
- [Contact](#-contact--kontak--اتصل-بنا)

---

# 1. 🇬🇧 English

## What is GoERP?

**GoERP** is a **multi-tenant SaaS ERP** built for Indonesian businesses. One installation serves hundreds of companies, each fully isolated by `tenant_id`.

Every operational transaction **auto-posts to the accounting ledger (double-entry)**. No standalone transaction without a journal.

**Different from Jurnal.id / Accurate / Mekari:**
- Production module: BOM + versioning, WIP, QC (good/reject/rework), material variance, actual HPP, borongan (piece-rate labor)
- Marketplace Excel import (Shopee / TikTok Shop / Lazada) with automatic SKU matching, duplicate protection, auto stock deduction
- SaaS from day-1: backoffice, subscriptions, billing, feature flags, impersonation, support tickets
- Customer self-service portal, POS outlets, CRM, HRM, Projects, Budgeting, Recurring Journals, Blog/CMS + programmatic SEO

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11 (PHP 8.2+) |
| Admin Panel | Filament 3.3 |
| Database | MySQL 8 |
| Public site | Blade + TailwindCSS + Vite |
| PDF | barryvdh/laravel-dompdf |
| Excel Import/Export | maatwebsite/excel |
| Auth (future mobile API) | Laravel Sanctum ready |
| Mobile | Flutter (roadmap) |

## Architecture (3 Layers)

```
SaaS Management Layer  → Tenant, Subscription, Billing, Backoffice, Feature Flags
Core ERP / Accounting  → Sales, Purchase, Cash & Bank, Expense, Inventory, Accounting, Assets, Contacts, Reports, Approval, Audit
Operational Layer      → Production (BOM/WIP/QC/HPP), Multi-Warehouse, Marketplace Excel + SKU Matching
```

Accounting flow:

```
TRANSACTION → SUB-LEDGER → JOURNAL ENTRY → GENERAL LEDGER → TRIAL BALANCE → FINANCIAL REPORT
Sales Invoice → AR → Dr Receivables / Cr Sales → GL per COA → Trial Balance → P&L / Balance Sheet / Cash Flow
```

## Complete Feature List (EN)

### A. SaaS & Multi-Tenant (6)
1. **Multi-tenant architecture** — one app, many customers; tenant = data boundary.
2. **Data isolation** — every record has `tenant_id`; global scope prevents leaks.
3. **Login + subscription check** — expired/suspended tenants become view-only, can renew.
4. **Multi-company** — one tenant can own multiple companies, switch from header.
5. **Multi-branch** — branches with PIC name/phone, default warehouse, active flag.
6. **Roles & permissions** — Owner, Finance, Accounting, Purchasing, Warehouse, Production, Sales, Auditor; View/Create/Edit/Delete/Approve/Export/Print per menu.

### B. Dashboard & Navigation (5)
7. **Main dashboard** — cash, AR, AP, inventory summary cards, filter by company/branch/period.
8. **Sales chart** — day/week/month/year with previous-period comparison.
9. **Cash-flow summary** — cash in, cash out, net.
10. **Quick actions** — +Invoice, +SO, +PO, +Expense, +Payment, +Product, +Contact.
11. **Global search & notifications** — search invoices/POs/products/contacts/journals; due-date, approval, low-stock, import-error notifications.

### C. Sales (9)
12. **Full sales flow** — Quotation → Sales Order → Delivery → Invoice → Payment.
13. **Sales Quotation** — expiry date, send/accept/reject, one-click convert to SO.
14. **Sales Order** — stock reservation, partial fulfillment, channel (offline/marketplace), salesperson.
15. **Delivery (Surat Jalan)** — partial delivery, remaining-qty tracking.
16. **Sales Invoice** — discount, tax, multi-branch/warehouse, due date, reference.
17. **Invoice status** — Draft → Open → Partial → Paid → Overdue → Void.
18. **Customer Payment** — full/partial, cash/transfer/giro, updates AR; **Invoice PDF** download.
19. **Sales Return** — stock-in + refund or credit note.
20. **Auto-journal (sales)** — Dr AR / Cr Sales; Dr COGS / Cr Inventory; Dr Bank / Cr AR.

### D. Purchase (7 + extras)
21. **Full purchase flow** — Request → PO → Receipt → Invoice → Payment.
22. **Purchase Request** — internal request before PO.
23. **Purchase Order** — approval workflow, expected delivery, payment terms; **PO PDF** download.
24. **Goods Receipt** — stock-in by actual received qty, partial receiving supported.
25. **Purchase Invoice** — supplier bill → AP, supplier invoice number, due date.
26. **Supplier Payment** — full/partial, updates AP.
27. **Purchase Return** — stock-out + AP reduction/refund.
28. **Auto-journal (purchase)** — Dr Inventory / Cr AP; Dr AP / Cr Bank.

### E. Product & Inventory (12)
29. **Product master** — name, base SKU, barcode, category, brand, unit, purchase/sell price, COA links, image, weight/dimensions.
30. **Product variants** — color/size/attributes; each combination = unique internal SKU.
31. **Internal SKU as single source of truth** — all modules reference it.
32. **Categories, Brands, Units** — hierarchical categories, brand master, unit master.
33. **Multi-warehouse** — per-warehouse stock, branch-linked warehouses.
34. **Stock balance** — On Hand / Reserved / Available + average cost & last purchase cost.
35. **Stock movement log** — immutable before/after log for every change (sale/purchase/transfer/adjustment/production).
36. **Warehouse transfer** — Draft → Approved → In Transit → Received.
37. **Stock adjustment** — in/out/lost/damage/reject/correction/return with approval.
38. **Stock opname** — system vs physical, variance, approval → auto adjustment.
39. **Inventory reports** — summary, detail, stock card, valuation, movement, low-stock, negative-stock alerts.
40. **Excel import/export** — bulk product import/export via Filament.

### F. Cash, Bank, Expense, Contacts (10)
41. **Bank & cash accounts** — linked to COA, initial/current balance.
42. **Receive money** — cash-in not from invoice.
43. **Send money** — cash-out to expense/asset account.
44. **Inter-bank transfer** — between company accounts.
45. **Bank reconciliation** — match system vs bank statement, reconciled flag + date.
46. **Expense** — category, department, branch, tax, attachment, approval.
47. **Cash Advance (Kas Bon)** — employee advance + settlement tracking.
48. **Petty Cash (Kas Kecil)** — small-cash ledger per outlet/branch.
49. **Payment methods** — cash, transfer, giro, VA, e-wallet, other.
50. **Contacts** — customer/supplier/employee/other with code, NPWP/NIK, payment terms, credit limit.

### G. Accounting Core (10)
51. **Chart of Accounts (COA)** — hierarchical: 1-Asset, 2-Liability, 3-Equity, 4-Revenue, 5-COGS, 6-Expense, 7-Other Income, 8-Other Expense; lock flag for system accounts.
52. **Journal entries** — auto-generated from every transaction + manual view.
53. **Manual journal** — debit must equal credit validation.
54. **Recurring journals** — scheduled repeating entries (rent, subscriptions).
55. **General ledger** — per-account opening → movements → closing balance.
56. **Opening balance** — initial balances incl. AR/AP per contact.
57. **Fiscal periods, lock period & closing** — lock `YYYY-MM` against backdate edits; closing checklist (bank reconciled, opname done, depreciation run, trial balance OK) → transfer P&L to retained earnings.
58. **Multi-currency** — base + transaction currency with exchange rates.
59. **Tax rates** — name, rate, inclusive/exclusive, COA link.
60. **Budgeting** — budget per account/period vs actual report.

### H. Fixed Assets & Financial Reports (8)
61. **Fixed assets** — register, category, acquisition date/cost, residual value, useful life, straight-line / double-declining depreciation, auto depreciation schedule + journal.
62. **Profit & Loss** — Revenue − COGS = Gross − Expenses = Net.
63. **Balance Sheet** — Assets = Liabilities + Equity.
64. **Cash Flow** — operating / investing / financing.
65. **Trial Balance** — debits = credits check.
66. **Sales reports** — by product, customer, salesperson, channel, branch, date; AR aging.
67. **Purchase reports** — by supplier, product, branch; AP aging.
68. **Report templates + PDF/Excel export** — save report layouts, export any report to PDF/Excel.

### I. Approval, Workflow & Audit (5)
69. **Approval workflow** — Draft → Submitted → Waiting → Approved → Posted / Rejected.
70. **Approval rules / Workflow rules** — multi-level by amount (e.g. <5M Supervisor, 5–50M Manager, >50M Owner).
71. **Audit trail** — user, datetime, module, document type/no, old/new JSON, IP, user agent.
72. **Login history** — every login tracked per user/device/IP.
73. **Notifications** — due dates, approvals, low stock, import errors.

### J. Marketplace Excel Import (10)
74. **No-API concept (V1)** — download Excel from Shopee/TikTok/Lazada → upload to GoERP.
75. **Import wizard** — select marketplace + warehouse, upload XLSX/XLS/CSV.
76. **Smart parsing** — order no, date, marketplace SKU, product name, variant, qty, price, discount.
77. **Auto SKU match** — marketplace SKU = internal SKU → instant link.
78. **Manual SKU match** — pick internal product, mapping saved for future imports.
79. **Bulk SKU matching** — resolve all unmatched SKUs on one screen.
80. **Preview before commit** — totals: orders, items, matched, unmatched, duplicates; block import if unmatched remain.
81. **Duplicate protection** — marketplace item ID checked against DB; skips already-imported orders.
82. **Auto stock deduction** — stock movement created on internal SKU after import.
83. **Import history log** — file, date, marketplace, counts, status (Uploaded/Matched/Previewed/Imported/Failed).

### K. Production (13)
84. **Production flow** — BOM → Production Order → Material Request → Material Issue → WIP → Output → QC.
85. **Bill of Materials (BOM)** — material qty per finished unit, expected output, waste %, standard labor/overhead.
86. **BOM versioning** — new version = new record; old orders keep their version.
87. **Production Order** — target qty, BOM version, start/due dates, raw & finished warehouses.
88. **Work Orders** — stages: cutting → sewing → finishing → QC → packing; team/operator, target/actual/reject/rework qty.
89. **Material Request** — production requests raw material from warehouse.
90. **Material Issue** — stock decreases, value moves to WIP (Dr WIP / Cr Raw Material).
91. **WIP tracking** — value of goods still in production.
92. **Material variance** — standard (BOM) vs actual usage.
93. **Production output & QC** — good / reject / rework classification per output.
94. **Reject & rework** — defect reasons (hole stitching, dirty, size, color, other), reject warehouse.
95. **Actual HPP** — total material + labor + overhead ÷ good output.
96. **Borongan (piece rate)** — pay per operator per operation per qty (Dr Production Labor / Cr Cash/Bank).

### L. HRM, CRM, Projects, POS (12)
97. **Employees** — profile, department, position, branch.
98. **Departments & Business Units** — org structure master.
99. **Sales Leads** — prospect pipeline.
100. **Opportunities + Activities** — deal stages + follow-up activity log.
101. **Projects** — project tracker linked to costs.
102. **POS Outlets** — outlet master for retail/POS use.
103. **Promotions** — discount/promo master.
104. **Customer portal** — customers login to see their invoices & payment history.
105. **Blog / CMS** — categories + posts, published scheduling, public blog pages.
106. **Programmatic SEO** — best-category, alternatives, compare, under-price, learn-skill pages + sitemap + IndexNow.
107. **Docs page** — in-app documentation route.
108. **Settings per module** — company, sales, purchase, inventory, production, marketplace, accounting, tax, notification, transaction numbers (`INV/{YYYY}/{MM}/{####}`), attachments (PDF/JPG/PNG/XLSX).

### M. SaaS Backoffice — Superadmin Only (16)
109. **Separate admin panel** (`/admin`) for platform owner.
110. **SaaS dashboard** — tenant count, active/trial/expired, MRR, outstanding invoices.
111. **Tenant management** — list with package, dates, users, status.
112. **Tenant detail** — companies, subscription, users, features, usage, billing, support.
113. **Subscription plans** — Starter/Pro/Business/Enterprise editable without code.
114. **Feature entitlement** — per-plan flags (accounting, inventory, production, marketplace, approval…).
115. **Package limits** — max users/companies/branches/warehouses/storage.
116. **Subscription lifecycle** — Trial → Active → Due → Grace → Suspended; expired = view-only, data kept.
117. **Billing** — subscription invoices, payments, renewal, discount, coupon, tax.
118. **Usage monitor** — users, companies, products, transactions per tenant.
119. **Feature control override** — toggle features per tenant.
120. **Impersonation (login as customer)** — fully logged with activity JSON.
121. **Support tickets** — tenant → staff thread with priority/assignment.
122. **Announcements** — broadcast to all / per-plan / per-tenant.
123. **Backup** — scheduled DB backup + history + restore control.
124. **Activity & audit log** — platform-wide visibility.

### N. Integrations & System (8)
125. **API keys** — per-tenant keys for integrations.
126. **Integrations manager** — configurable providers (payment/SMS/storage/AI), no hardcoded secrets; encrypted at rest.
127. **AI Providers (BYOK)** — use your own AI key for forecasting/assistant features.
128. **Notifications center** — in-app notification resource.
129. **Users & impersonation log** — full user admin.
130. **Import/Export framework** — every master supports Excel import/export.
131. **License pairing** — whitelabel pairing wizard (`/__pair`) with RSA + AES-256-GCM lock file.
132. **Scheduler + queue** — cron `schedule:run`, supervisor queue workers.

---

# 2. 🇮🇩 Bahasa Indonesia

## Apa itu GoERP?

**GoERP** adalah **ERP SaaS multi-tenant** untuk bisnis Indonesia. Satu aplikasi melayani ratusan perusahaan, masing-masing terisolasi penuh lewat `tenant_id`.

Setiap transaksi operasional **otomatis menjurnal ke buku besar (double-entry)**. Tidak ada transaksi yang berdiri sendiri tanpa jurnal.

**Beda dari Jurnal.id / Accurate / Mekari:**
- Modul produksi: BOM + versioning, WIP, QC (bagus/reject/rework), selisih bahan, HPP aktual, upah borongan
- Import Excel marketplace (Shopee / TikTok Shop / Lazada) dengan pencocokan SKU otomatis, proteksi duplikat, potong stok otomatis
- SaaS sejak hari pertama: backoffice, langganan, billing, feature flag, impersonation, tiket support
- Portal mandiri customer, outlet POS, CRM, HRM, proyek, budgeting, jurnal berulang, Blog/CMS + SEO programatik

## Tumpukan Teknologi

| Lapisan | Teknologi |
|---|---|
| Backend | Laravel 11 (PHP 8.2+) |
| Panel Admin | Filament 3.3 |
| Database | MySQL 8 |
| Website publik | Blade + TailwindCSS + Vite |
| PDF | barryvdh/laravel-dompdf |
| Excel Import/Ekspor | maatwebsite/excel |

## Daftar Fitur Lengkap (ID)

### A. SaaS & Multi-Tenant (6)
1. **Arsitektur multi-tenant** — satu aplikasi untuk banyak pelanggan; tenant = batas data.
2. **Isolasi data** — semua record punya `tenant_id`; tidak ada kebocoran antar tenant.
3. **Login + cek langganan** — tenant kedaluwarsa jadi view-only, bisa perpanjang.
4. **Multi-perusahaan** — satu tenant bisa punya banyak perusahaan, ganti via header.
5. **Multi-cabang** — cabang dengan nama PIC/telp, gudang default, status aktif.
6. **Role & permission** — Owner, Finance, Accounting, Purchasing, Gudang, Produksi, Sales, Auditor; hak View/Create/Edit/Delete/Approve/Export/Print per menu.

### B. Dashboard & Navigasi (5)
7. **Dashboard utama** — kartu kas, piutang, hutang, inventory + filter perusahaan/cabang/periode.
8. **Grafik penjualan** — harian/mingguan/bulanan/tahunan + perbandingan periode lalu.
9. **Ringkasan arus kas** — kas masuk, kas keluar, bersih.
10. **Aksi cepat** — tombol +Faktur, +SO, +PO, +Biaya, +Pembayaran, +Produk, +Kontak.
11. **Pencarian global & notifikasi** — cari faktur/PO/produk/kontak/jurnal; notifikasi jatuh tempo, approval, stok menipis, error import.

### C. Penjualan (9)
12. **Alur penjualan penuh** — Penawaran → Sales Order → Pengiriman → Faktur → Pembayaran.
13. **Penawaran (Quotation)** — tanggal kedaluwarsa, kirim/terima/tolak, convert ke SO sekali klik.
14. **Sales Order** — reservasi stok, pelunasan parsial, channel & sales.
15. **Pengiriman (Surat Jalan)** — pengiriman parsial, sisa qty terpantau.
16. **Faktur penjualan** — diskon, pajak, multi-cabang/gudang, jatuh tempo.
17. **Status faktur** — Draft → Open → Partial → Paid → Overdue → Void.
18. **Pembayaran customer** — lunas/cicilan, cash/transfer/giro, update piutang; **download PDF faktur**.
19. **Retur penjualan** — barang masuk + refund atau nota kredit.
20. **Jurnal otomatis (penjualan)** — Dr Piutang / Cr Penjualan; Dr HPP / Cr Persediaan; Dr Bank / Cr Piutang.

### D. Pembelian (7+)
21. **Alur pembelian penuh** — Permintaan → PO → Penerimaan → Faktur → Pembayaran.
22. **Purchase Request** — permintaan internal sebelum PO.
23. **Purchase Order** — workflow approval, tanggal kirim, termin; **download PDF PO**.
24. **Penerimaan barang** — stok masuk sesuai nyata, bisa parsial.
25. **Faktur pembelian** — tagihan supplier → hutang.
26. **Pembayaran supplier** — lunas/cicilan, update hutang.
27. **Retur pembelian** — stok keluar + pengurang hutang/refund.
28. **Jurnal otomatis (pembelian)** — Dr Persediaan / Cr Hutang; Dr Hutang / Cr Bank.

### E. Produk & Inventory (12)
29. **Master produk** — nama, SKU, barcode, kategori, brand, satuan, harga beli/jual, akun COA, foto, berat/dimensi.
30. **Varian produk** — warna/ukuran/atribut; tiap kombinasi = SKU internal unik.
31. **SKU internal sebagai kunci utama** — semua modul mengacu ke sini.
32. **Kategori, Brand, Satuan** — kategori bertingkat, master brand & satuan.
33. **Multi-gudang** — stok per gudang, terhubung ke cabang.
34. **Saldo stok** — On Hand / Reserved / Available + harga rata-rata & harga beli terakhir.
35. **Kartu mutasi stok** — log before/after yang tidak bisa diubah.
36. **Transfer gudang** — Draft → Approved → In Transit → Received.
37. **Penyesuaian stok** — masuk/keluar/hilang/rusak/reject/koreksi/retur + approval.
38. **Stok opname** — sistem vs fisik, selisih, approval → penyesuaian otomatis.
39. **Laporan inventory** — ringkasan, detail, kartu stok, valuasi, mutasi, stok menipis, stok negatif.
40. **Import/ekspor Excel** — produk massal via Filament.

### F. Kas, Bank, Biaya, Kontak (10)
41. **Akun bank & kas** — terhubung COA, saldo awal/berjalan.
42. **Terima uang** — kas masuk di luar pembayaran faktur.
43. **Kirim uang** — kas keluar ke akun biaya/aset.
44. **Transfer antar bank** — antar rekening perusahaan.
45. **Rekonsiliasi bank** — cocokkan sistem vs mutasi bank.
46. **Biaya operasional** — kategori, departemen, cabang, pajak, lampiran, approval.
47. **Kas bon** — panjar karyawan + penyelesaian.
48. **Kas kecil** — buku kas kecil per outlet/cabang.
49. **Metode pembayaran** — cash, transfer, giro, VA, e-wallet, lainnya.
50. **Kontak** — customer/supplier/karyawan/lainnya + NPWP/NIK, termin, limit kredit.

### G. Akuntansi Inti (10)
51. **Chart of Accounts (COA)** — bertingkat: 1-Aset, 2-Kewajiban, 3-Ekuitas, 4-Pendapatan, 5-HPP, 6-Beban, 7/8-Lainnya; akun sistem bisa dikunci.
52. **Jurnal umum** — otomatis dari tiap transaksi + tampilan terpusat.
53. **Jurnal manual** — validasi debit = kredit.
54. **Jurnal berulang** — entri terjadwal (sewa, langganan).
55. **Buku besar** — saldo awal → mutasi → saldo akhir per akun.
56. **Saldo awal** — termasuk piutang/hutang per kontak.
57. **Periode fiskal, kunci periode & tutup buku** — kunci `YYYY-MM` dari edit backdate; checklist (rekonsiliasi bank, opname, penyusutan, trial balance OK) → laba rugi dipindah ke laba ditahan.
58. **Multi-mata uang** — kurs + mata uang transaksi.
59. **Tarif pajak** — nama, tarif, inclusive/exclusive, akun COA.
60. **Budgeting** — anggaran per akun/periode vs realisasi.

### H. Aset Tetap & Laporan Keuangan (8)
61. **Aset tetap** — register, kategori, tgl/nilai perolehan, nilai sisa, umur manfaat, penyusutan garis lurus / saldo menurun + jurnal otomatis.
62. **Laba rugi** — Pendapatan − HPP = Laba Kotor − Beban = Laba Bersih.
63. **Neraca** — Aset = Kewajiban + Ekuitas.
64. **Arus kas** — operasi / investasi / pendanaan.
65. **Neraca saldo** — cek debit = kredit.
66. **Laporan penjualan** — per produk, customer, sales, channel, cabang, tanggal; aging piutang.
67. **Laporan pembelian** — per supplier, produk, cabang; aging hutang.
68. **Template laporan + ekspor PDF/Excel** — simpan layout, ekspor semua laporan.

### I. Approval, Workflow & Audit (5)
69. **Workflow approval** — Draft → Submitted → Waiting → Approved → Posted / Rejected.
70. **Aturan approval** — bertingkat berdasar nominal (mis. <5 jt Supervisor, 5–50 jt Manager, >50 jt Owner).
71. **Audit trail** — user, waktu, modul, tipe/no dokumen, old/new JSON, IP, user agent.
72. **Riwayat login** — semua login tercatat per user/perangkat/IP.
73. **Notifikasi** — jatuh tempo, approval, stok menipis, error import.

### J. Import Excel Marketplace (10)
74. **Konsep tanpa API (V1)** — unduh Excel dari Shopee/TikTok/Lazada → upload ke GoERP.
75. **Wizard import** — pilih marketplace + gudang, upload XLSX/XLS/CSV.
76. **Parsing cerdas** — no order, tanggal, SKU marketplace, nama, varian, qty, harga, diskon.
77. **Cocok SKU otomatis** — SKU marketplace = SKU internal → langsung terhubung.
78. **Cocok SKU manual** — pilih produk internal, mapping tersimpan untuk import berikut.
79. **Bulk SKU matching** — bereskan semua SKU tak dikenal di satu layar.
80. **Preview sebelum commit** — total order, item, cocok, tak cocok, duplikat; import diblokir jika masih ada yang tak cocok.
81. **Proteksi duplikat** — ID item marketplace dicek ke DB; order yang sudah masuk dilewati.
82. **Potong stok otomatis** — mutasi stok SKU internal setelah import.
83. **Riwayat import** — file, tanggal, marketplace, jumlah, status.

### K. Produksi (13)
84. **Alur produksi** — BOM → Production Order → Permintaan Bahan → Pengeluaran Bahan → WIP → Output → QC.
85. **Bill of Materials (BOM)** — kebutuhan bahan per unit jadi, waste %, biaya tenaga kerja/overhead standar.
86. **Versioning BOM** — versi baru = record baru; order lama pakai versi lama.
87. **Production Order** — target qty, versi BOM, tgl mulai/jatuh tempo, gudang bahan & jadi.
88. **Work Order** — tahap: cutting → sewing → finishing → QC → packing; tim/operator, target/aktual/reject/rework.
89. **Permintaan bahan** — produksi minta bahan ke gudang.
90. **Pengeluaran bahan** — stok berkurang, nilai pindah ke WIP (Dr WIP / Cr Bahan Baku).
91. **WIP** — nilai barang dalam proses.
92. **Selisih bahan** — standar (BOM) vs aktual.
93. **Output & QC** — klasifikasi bagus / reject / rework.
94. **Reject & rework** — alasan defect (jahitan bolong, kotor, ukuran, warna, dll), gudang reject.
95. **HPP aktual** — total bahan + tenaga + overhead ÷ output bagus.
96. **Borongan** — upah per operator per operasi per qty (Dr Beban Produksi / Cr Kas/Bank).

### L. HRM, CRM, Proyek, POS (12)
97. **Karyawan** — profil, departemen, jabatan, cabang.
98. **Departemen & unit bisnis** — struktur organisasi.
99. **Leads** — pipeline prospek.
100. **Opportunity + aktivitas** — tahap deal + log follow-up.
101. **Proyek** — tracker proyek + biaya.
102. **Outlet POS** — master outlet retail/POS.
103. **Promosi** — master diskon/promo.
104. **Portal customer** — customer login lihat faktur & riwayat bayar.
105. **Blog / CMS** — kategori + artikel, jadwal publish, halaman blog publik.
106. **SEO programatik** — halaman best-category, alternatives, compare, under-price, learn-skill + sitemap + IndexNow.
107. **Halaman dokumentasi** — dokumentasi dalam aplikasi.
108. **Pengaturan per modul** — perusahaan, penjualan, pembelian, inventory, produksi, marketplace, akuntansi, pajak, notifikasi, format nomor (`INV/{YYYY}/{MM}/{####}`), lampiran.

### M. Backoffice SaaS — Khusus Superadmin (16)
109. **Panel admin terpisah** (`/admin`) untuk pemilik platform.
110. **Dashboard SaaS** — jumlah tenant, aktif/trial/expired, MRR, tagihan outstanding.
111. **Manajemen tenant** — daftar + paket, tanggal, user, status.
112. **Detail tenant** — perusahaan, langganan, user, fitur, usage, billing, support.
113. **Paket langganan** — Starter/Pro/Business/Enterprise bisa diubah tanpa koding.
114. **Hak fitur per paket** — flag accounting, inventory, produksi, marketplace, approval…
115. **Limit paket** — maks user/perusahaan/cabang/gudang/penyimpanan.
116. **Siklus langganan** — Trial → Active → Due → Grace → Suspended; expired = view-only, data aman.
117. **Billing** — faktur langganan, pembayaran, perpanjangan, diskon, kupon, pajak.
118. **Monitor usage** — user, perusahaan, produk, transaksi per tenant.
119. **Override fitur** — toggle fitur per tenant.
120. **Impersonation (login sebagai customer)** — tercatat penuh + aktivitas JSON.
121. **Tiket support** — thread tenant → staff + prioritas/assign.
122. **Pengumuman** — broadcast ke semua / per paket / per tenant.
123. **Backup** — backup DB terjadwal + riwayat + restore.
124. **Log aktivitas & audit** — visibilitas se-platform.

### N. Integrasi & Sistem (8)
125. **API keys** — kunci per tenant untuk integrasi.
126. **Manajer integrasi** — provider terkonfigurasi (payment/SMS/storage/AI), tanpa secret hardcoded; terenkripsi.
127. **AI Providers (BYOK)** — pakai kunci AI sendiri untuk forecasting/asisten.
128. **Pusat notifikasi** — resource notifikasi dalam aplikasi.
129. **User & log impersonation** — admin user penuh.
130. **Framework import/ekspor** — semua master dukung Excel.
131. **License pairing** — wizard pairing whitelabel (`/__pair`) RSA + AES-256-GCM.
132. **Scheduler + queue** — cron `schedule:run`, queue worker supervisor.

---

# 3. 🇸🇦 العربية (Arabic)

## ما هو GoERP؟

**GoERP** هو نظام **ERP سحابي متعدد المستأجرين (Multi-Tenant)** مصمم للشركات الإندونيسية. تثبيت واحد يخدم مئات الشركات، وكل شركة معزولة تمامًا عبر `tenant_id`.

كل معاملة تشغيلية **تُرحّل تلقائيًا إلى دفتر الأستاذ (قيد مزدوج)**. لا توجد معاملة بدون قيد محاسبي.

**ما يميزه عن Jurnal.id / Accurate / Mekari:**
- وحدة الإنتاج: BOM مع إصدارات، WIP (تحت التشغيل)، QC (سليم/تالف/إعادة عمل)، فروقات المواد، تكلفة الإنتاج الفعلية (HPP)، أجور القطعة (borongan)
- استيراد Excel للمتاجر (Shopee / TikTok Shop / Lazada) مع مطابقة SKU تلقائية، وحماية من التكرار، وخصم المخزون تلقائيًا
- SaaS منذ اليوم الأول: لوحة المالك، الاشتراكات، الفوترة، أعلام الميزات، انتحال الدخول، تذاكر الدعم
- بوابة العملاء، نقاط البيع (POS)، CRM، HRM، المشاريع، الموازنات، القيود المتكررة، مدونة/CMS + سيو برمجي

## التقنيات

| الطبقة | التقنية |
|---|---|
| الخلفية | Laravel 11 (PHP 8.2+) |
| لوحة الإدارة | Filament 3.3 |
| قاعدة البيانات | MySQL 8 |
| الموقع العام | Blade + TailwindCSS + Vite |
| PDF | barryvdh/laravel-dompdf |
| Excel | maatwebsite/excel |

## قائمة الميزات الكاملة (AR)

### أ. SaaS وتعدد المستأجرين (6)
1. **بنية متعددة المستأجرين** — تطبيق واحد للعديد من العملاء.
2. **عزل البيانات** — كل سجل يحمل `tenant_id`؛ لا تسرب بين العملاء.
3. **تسجيل الدخول + فحص الاشتراك** — المنتهي يصبح للعرض فقط مع إمكانية التجديد.
4. **شركات متعددة** — المستأجر يملك عدة شركات والتبديل من الأعلى.
5. **فروع متعددة** — الفروع مع المسؤول والمستودع الافتراضي.
6. **الأدوار والصلاحيات** — مالك، مالية، محاسبة، مشتريات، مستودع، إنتاج، مبيعات، مدقق؛ عرض/إنشاء/تعديل/حذف/اعتماد/تصدير/طباعة لكل قائمة.

### ب. لوحة التحكم والتنقل (5)
7. **لوحة رئيسية** — النقدية، الذمم المدينة/الدائنة، المخزون + فلتر الشركة/الفرع/الفترة.
8. **مخطط المبيعات** — يومي/أسبوعي/شهري/سنوي مع مقارنة الفترة السابقة.
9. **ملخص التدفق النقدي** — داخل، خارج، صافي.
10. **إجراءات سريعة** — +فاتورة، +طلب بيع، +طلب شراء، +مصروف، +دفعة، +منتج، +جهة اتصال.
11. **بحث شامل وإشعارات** — بحث الفواتير/المنتجات/القيود؛ إشعارات الاستحقاق والاعتماد وانخفاض المخزون.

### ج. المبيعات (9)
12. **دورة كاملة** — عرض سعر ← طلب بيع ← تسليم ← فاتورة ← دفعة.
13. **عروض الأسعار** — تاريخ انتهاء، إرسال/قبول/رفض، تحويل لطلب بضغطة.
14. **طلبات البيع** — حجز المخزون، تنفيذ جزئي، القناة والمندوب.
15. **التسليم** — تسليم جزئي وتتبع المتبقي.
16. **فواتير البيع** — خصم، ضريبة، فروع/مستودعات، استحقاق.
17. **حالات الفاتورة** — مسودة ← مفتوحة ← جزئية ← مدفوعة ← متأخرة ← ملغاة.
18. **مدفوعات العملاء** — كاملة/جزئية، نقدي/تحويل/شيك، تحديث الذمم؛ **تحميل PDF**.
19. **مرتجعات البيع** — دخول مخزني + استرداد أو إشعار دائن.
20. **قيود تلقائية** — مدين ذمم / دائن مبيعات؛ مدين تكلفة / دائن مخزون؛ مدين بنك / دائن ذمم.

### د. المشتريات (7+)
21. **دورة كاملة** — طلب داخلي ← أمر شراء ← استلام ← فاتورة ← دفعة.
22. **طلب الشراء الداخلي** قبل أمر الشراء.
23. **أوامر الشراء** — اعتماد، تاريخ التسليم، شروط الدفع؛ **PDF**.
24. **استلام البضاعة** — بالكمية الفعلية، واستلام جزئي.
25. **فواتير الشراء** — فاتورة المورد ← ذمم دائنة.
26. **مدفوعات الموردين** — كاملة/جزئية وتحديث الذمم.
27. **مرتجعات الشراء** — خروج مخزني + تخفيض الذمم/استرداد.
28. **قيود تلقائية** — مدين مخزون / دائن ذمم؛ مدين ذمم / دائن بنك.

### هـ. المنتجات والمخزون (12)
29. **بطاقة المنتج** — الاسم، SKU، باركود، فئة، علامة، وحدة، سعري الشراء/البيع، حسابات COA، صورة.
30. **المتغيرات** — لون/مقاس/خصائص؛ كل تركيبة = SKU داخلي فريد.
31. **SKU الداخلي مرجع وحيد** لكل الوحدات.
32. **الفئات والعلامات والوحدات** — فئات هرمية.
33. **مستودعات متعددة** — مخزون لكل مستودع مرتبط بالفرع.
34. **أرصدة المخزون** — متاح فعلي / محجوز / صافي + متوسط التكلفة وآخر سعر.
35. **سجل الحركات** — قبل/بعد غير قابل للتعديل لكل حركة.
36. **التحويل بين المستودعات** — مسودة ← معتمد ← بالطريق ← مستلم.
37. **التسويات** — داخل/خارج/مفقود/تالف/مرفوض/تصحيح/مرتجع مع اعتماد.
38. **الجرد الفعلي (Opname)** — النظام مقابل الفعلي، الفروقات، اعتماد ← تسوية تلقائية.
39. **تقارير المخزون** — ملخص، تفصيلي، بطاقة صنف، تقييم، حركات، منخفض، سالب.
40. **استيراد/تصدير Excel** للمنتجات.

### و. النقدية والبنوك والمصروفات وجهات الاتصال (10)
41. **حسابات البنوك والنقدية** — مرتبطة بـ COA مع أرصدة.
42. **قبض** — نقد داخل خارج الفواتير.
43. **صرف** — نقد خارج لحساب مصروف/أصل.
44. **تحويل بين البنوك**.
45. **تسوية بنكية** — مطابقة النظام مع كشف البنك.
46. **المصروفات** — فئة، قسم، فرع، ضريبة، مرفق، اعتماد.
47. **السلف (Kas Bon)** — سلف الموظفين وتسويتها.
48. **الصندوق الصغير (Petty Cash)** لكل فرع/منفذ.
49. **طرق الدفع** — نقدي، تحويل، شيك، VA، محافظ، أخرى.
50. **جهات الاتصال** — عميل/مورد/موظف/أخرى مع NPWP/NIK وشروط الدفع والحد الائتماني.

### ز. المحاسبة الأساسية (10)
51. **الدليل المحاسبي (COA)** — هرمي: 1-أصول، 2-خصوم، 3-حقوق، 4-إيراد، 5-تكلفة، 6-مصروف، 7/8-أخرى؛ قفل حسابات النظام.
52. **القيود** — تلقائية من كل معاملة + عرض مركزي.
53. **قيد يدوي** — المدين يجب أن يساوي الدائن.
54. **القيود المتكررة** — مجدولة (إيجار، اشتراكات).
55. **الأستاذ العام** — رصيد أول ← حركات ← رصيد آخر لكل حساب.
56. **الأرصدة الافتتاحية** — بما فيها الذمم لكل جهة.
57. **الفترات المالية والقفل والإقفال** — قفل `YYYY-MM` ضد التعديل بأثر رجعي؛ قائمة الإقفال (تسوية بنكية، جرد، إهلاك، ميزان سليم) ← ترحيل الأرباح للأرباح المحتجزة.
58. **عملات متعددة** — أسعار الصرف.
59. **الضرائب** — الاسم، النسبة، شامل/غير شامل، الحساب.
60. **الموازنات** — موازنة لكل حساب/فترة مقابل الفعلي.

### ح. الأصول الثابتة والتقارير المالية (8)
61. **الأصول الثابتة** — سجل، فئة، تاريخ/تكلفة الاقتناء، القيمة المتبقية، العمر، إهلاك ثابت/متناقص + قيد تلقائي.
62. **الأرباح والخسائر** — الإيراد − التكلفة = مجمل − المصروف = صافي.
63. **الميزانية العمومية** — الأصول = الخصوم + الحقوق.
64. **التدفق النقدي** — تشغيلي / استثماري / تمويلي.
65. **ميزان المراجعة** — المدين = الدائن.
66. **تقارير المبيعات** — حسب المنتج/العميل/المندوب/القناة/الفرع/التاريخ؛ أعمار الذمم.
67. **تقارير المشتريات** — حسب المورد/المنتج/الفرع؛ أعمار الذمم الدائنة.
68. **قوالب التقارير + تصدير PDF/Excel**.

### ط. الاعتماد والتدقيق (5)
69. **سير الاعتماد** — مسودة ← مُرسل ← بانتظار ← معتمد ← مُرحّل / مرفوض.
70. **قواعد الاعتماد** — متعددة المستويات حسب المبلغ.
71. **سجل التدقيق** — المستخدم، الوقت، الوحدة، المستند، قديم/جديد JSON، IP، الجهاز.
72. **سجل الدخول** لكل مستخدم/جهاز/IP.
73. **الإشعارات** — استحقاق، اعتماد، مخزون منخفض، أخطاء الاستيراد.

### ي. استيراد Excel للمتاجر (10)
74. **بدون API (V1)** — تنزيل Excel من Shopee/TikTok/Lazada ← رفعه إلى GoERP.
75. **معالج الاستيراد** — اختيار المتجر + المستودع، رفع XLSX/XLS/CSV.
76. **تحليل ذكي** — رقم الطلب، التاريخ، SKU المتجر، الاسم، المتغير، الكمية، السعر، الخصم.
77. **مطابقة تلقائية** — SKU المتجر = الداخلي ← ربط فوري.
78. **مطابقة يدوية** — اختيار المنتج الداخلي وحفظ الربط مستقبلًا.
79. **مطابقة جماعية** في شاشة واحدة.
80. **معاينة قبل الترحيل** — الإجماليات: طلبات، أصناف، مطابق، غير مطابق، مكرر؛ منع الاستيراد عند وجود غير مطابق.
81. **حماية التكرار** — فحص ID المتجر ضد قاعدة البيانات.
82. **خصم المخزون تلقائيًا** بعد الاستيراد.
83. **سجل الاستيراد** — الملف، التاريخ، المتجر، الأعداد، الحالة.

### ك. الإنتاج (13)
84. **الدورة** — BOM ← أمر إنتاج ← طلب مواد ← صرف ← WIP ← مخرجات ← QC.
85. **BOM** — احتياج المواد لكل وحدة، نسبة الهالك، أجور/مصاريف معيارية.
86. **إصدارات BOM** — الإصدار الجديد = سجل جديد.
87. **أمر الإنتاج** — الكمية، إصدار BOM، تواريخ، مستودعات الخام والتام.
88. **أوامر التشغيل** — قص ← خياطة ← تشطيب ← QC ← تغليف؛ فريق/عامل وكميات.
89. **طلب المواد** من المستودع.
90. **صرف المواد** — نقص المخزون وانتقال القيمة إلى WIP.
91. **تتبع WIP**.
92. **فروقات المواد** — معياري مقابل فعلي.
93. **المخرجات وQC** — سليم / تالف / إعادة عمل.
94. **التالف وإعادة العمل** — أسباب العيوب ومستودع التالف.
95. **التكلفة الفعلية (HPP)** — إجمالي المواد + الأجور + المصاريف ÷ المخرج السليم.
96. **أجور القطعة** لكل عامل/عملية/كمية.

### ل. HRM وCRM والمشاريع وPOS (12)
97. **الموظفون** — ملف، قسم، منصب، فرع.
98. **الأقسام ووحدات الأعمال**.
99. **العملاء المحتملون (Leads)**.
100. **الفرص والأنشطة** — مراحل الصفقات وسجل المتابعة.
101. **المشاريع** وتكاليفها.
102. **منافذ POS**.
103. **العروض والخصومات**.
104. **بوابة العملاء** — عرض الفواتير والمدفوعات.
105. **المدونة / CMS** — فئات ومقالات وجدولة نشر.
106. **سيو برمجي** — صفحات best/alternatives/compare/under-price/learn + خريطة + IndexNow.
107. **صفحة التوثيق** داخل التطبيق.
108. **إعدادات كل وحدة** — الشركة، المبيعات، المشتريات، المخزون، الإنتاج، المتاجر، المحاسبة، الضرائب، الإشعارات، أرقام المستندات، المرفقات.

### م. لوحة المالك (16)
109. **لوحة منفصلة** (`/admin`) لمالك المنصة.
110. **لوحة SaaS** — العملاء، النشط/التجريبي/المنتهي، MRR، المستحق.
111. **إدارة المستأجرين** مع الباقة والتواريخ والمستخدمين.
112. **تفاصيل المستأجر** — الشركات، الاشتراك، المستخدمون، الميزات، الاستخدام، الفوترة، الدعم.
113. **خطط الاشتراك** Starter/Pro/Business/Enterprise بدون كود.
114. **استحقاق الميزات** لكل خطة.
115. **حدود الباقات** — مستخدمون/شركات/فروع/مستودعات/تخزين.
116. **دورة الاشتراك** — تجريبي ← نشط ← مستحق ← سماح ← موقوف؛ المنتهي للعرض فقط.
117. **الفوترة** — فواتير الاشتراك، الدفع، التجديد، الخصم، الكوبون، الضريبة.
118. **مراقبة الاستخدام** لكل مستأجر.
119. **تحكم فردي** — تفعيل/تعطيل الميزات لكل مستأجر.
120. **انتحال الدخول** — دخول كعميل مع تسجيل كامل.
121. **تذاكر الدعم** مع الأولوية والإسناد.
122. **الإعلانات** — للجميع / لخطة / لمستأجر.
123. **النسخ الاحتياطي** — مجدول + سجل + استعادة.
124. **سجلات النشاط والتدقيق** للمنصة.

### ن. التكاملات والنظام (8)
125. **مفاتيح API** لكل مستأجر.
126. **مدير التكاملات** — مزودون قابلون للضبط ومشفرة.
127. **مزودو AI (BYOK)** — مفتاحك الخاص للتنبؤ/المساعد.
128. **مركز الإشعارات**.
129. **المستخدمون وسجل الانتحال**.
130. **استيراد/تصدير Excel** لكل البيانات الأساسية.
131. **ربط الترخيص** (`/__pair`) RSA + AES-256-GCM.
132. **المجدول والطوابير** — cron وsupervisor.

---

## 💳 Subscription Plans / Paket Harga / خطط الاشتراك

| Feature / Fitur / الميزة | Starter | Pro | Business | Enterprise |
|---|---|---|---|---|
| Accounting / Akuntansi / المحاسبة | ✅ Yes / Ya / نعم | ✅ | ✅ | ✅ |
| Inventory / Inventaris / المخزون | ✅ | ✅ | ✅ | ✅ |
| Multi-Warehouse / Multi-Gudang / مستودعات | ❌ | ✅ | ✅ | ✅ |
| Marketplace Import / Import Marketplace / استيراد المتاجر | ❌ | ❌ | ✅ | ✅ |
| Production / Produksi / الإنتاج | ❌ | ❌ | ✅ | ✅ |
| Approval / Persetujuan / الاعتماد | ❌ | ✅ | ✅ | ✅ |
| Max Users / Maks User / المستخدمون | 3 | 10 | 25 | Unlimited |
| Max Companies / Maks Perusahaan / الشركات | 1 | 3 | 10 | Unlimited |
| Max Branches / Maks Cabang / الفروع | 1 | 5 | 20 | Unlimited |
| Max Warehouses / Maks Gudang / المستودعات | 1 | 5 | 20 | Unlimited |
| Support / Dukungan / الدعم | Email | Priority Email | Chat + Email | Dedicated / Khusus / مخصص |

---

## 🚀 Installation / Instalasi / التثبيت

Requirements: PHP 8.2+, MySQL 8.0+, Composer 2.x, Node.js 18+, Nginx/Apache.

```bash
git clone https://github.com/linducip2208/goerp.git
cd goerp
composer install --no-dev --optimize-autoloader
npm install
npm run build
cp .env.example .env
php artisan key:generate
# edit .env (DB_*, APP_URL, LICENSE_*)
php artisan migrate
php artisan db:seed --class=DemoDataSeeder
php artisan make:filament-user --name="Admin" --email="admin@yourdomain.com"
chmod -R 775 storage bootstrap/cache
```

Scheduler (cron):

```
* * * * * cd /path/to/goerp && php artisan schedule:run >> /dev/null 2>&1
```

Queue (supervisor `/etc/supervisor/conf.d/goerp-worker.conf`):

```ini
[program:goerp-worker]
command=php /path/to/goerp/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
```

Useful commands / Perintah berguna / أوامر مفيدة:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate:fresh --seed
php artisan backup:database
```

Panels:
- App: `/app` — tenant users
- Backoffice: `/admin` — superadmin (tenants, subscriptions, billing, support, announcements, backups)
- Customer portal: `/portal` — customer login (invoices, payments)

---

## 📁 Project Structure

```
goerp/
├── app/Models/            → 101 Eloquent models
├── app/Filament/App/      → ~68 tenant resources (Sales, Purchase, Inventory, Production, Accounting…)
├── app/Filament/Admin/    → 9 backoffice resources (Tenants, Plans, Subscriptions, Billing, Support…)
├── database/migrations/   → 109 migrations (~60+ tables)
├── docs/                  → 01-ARCHITECTURE, 02-PRD, 03-ERD, 04-MODULES
├── routes/                → web.php, api.php, console.php, pair-routes.php
├── resources/views/       → Blade (welcome, blog, portal, docs, SEO)
└── public/                → web root + sitemap.xml + indexnow-key.txt
```

Full database map: see [`docs/03-ERD.md`](docs/03-ERD.md). Full module index: [`docs/04-MODULES.md`](docs/04-MODULES.md). Deploy guide: [`DEPLOYMENT.md`](DEPLOYMENT.md).

---

## 📞 Contact / Kontak / اتصل بنا

**Developer: Lindu Cipta**
**WhatsApp: [+6281296052010](https://wa.me/6281296052010)**

- 🇬🇧 EN: Need installation, customization, new modules, or a demo? Chat on WhatsApp: https://wa.me/6281296052010
- 🇮🇩 ID: Butuh instalasi, kustomisasi, modul baru, atau demo? Chat WhatsApp: https://wa.me/6281296052010 (Lindu Cipta)
- 🇸🇦 AR: تحتاج تثبيتًا أو تخصيصًا أو وحدات جديدة أو عرضًا؟ راسلنا واتساب: https://wa.me/6281296052010 (Lindu Cipta)

## License

MIT — see `LICENSE` / open-source.
