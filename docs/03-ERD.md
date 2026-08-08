# GoERP — Entity Relationship Diagram (ERD)

## Database Overview: ~60 tables across 4 namespaces

---

## A. Core Tables (Tenant, Company, User)

```
┌─────────────────┐
│    tenants      │
│─────────────────│
│ id (PK)         │
│ name            │
│ domain          │
│ status          │── active / trial / expired / suspended
│ created_at      │
│ updated_at      │
└────────┬────────┘
         │ 1
         │
         │ M
┌────────▼────────┐     ┌──────────────────┐
│   companies     │     │    branches      │
│─────────────────│     │──────────────────│
│ id (PK)         │1   M│ id (PK)          │
│ tenant_id (FK)  │─────│ company_id (FK)  │
│ name            │     │ name             │
│ code            │     │ code             │
│ npwp            │     │ address          │
│ nib             │     │ pic_name         │
│ address         │     │ pic_phone        │
│ phone           │     │ default_warehouse│
│ email           │     │ is_active        │
│ logo            │     │ created_at       │
│ timezone        │     │ updated_at       │
│ date_format     │     └──────────────────┘
│ fiscal_year_start│
│ base_currency   │
│ created_at      │
│ updated_at      │
└────────┬────────┘
         │
         │
┌────────▼────────┐     ┌──────────────────┐
│     users       │     │     roles        │
│─────────────────│     │──────────────────│
│ id (PK)         │M   M│ id (PK)          │
│ tenant_id (FK)  │─────│ name             │
│ company_id (FK) │     │ guard_name       │
│ name            │     │ created_at       │
│ email           │     │ updated_at       │
│ password        │     └──────────────────┘
│ role_id (FK)    │
│ is_active       │     ┌──────────────────────────┐
│ last_login_at   │     │   role_permissions       │
│ created_at      │     │──────────────────────────│
│ updated_at      │     │ id (PK)                  │
└──────────────────┘     │ role_id (FK)             │
                         │ permission_name          │
                         └──────────────────────────┘
```

---

## B. Master Data: Product & Contacts

```
┌───────────────────┐
│    categories     │
│───────────────────│
│ id (PK)           │
│ tenant_id (FK)    │
│ name              │
│ description       │
│ parent_id (FK)    │── self-referencing
│ created_at        │
│ updated_at        │
└────────┬──────────┘
         │ 1
         │ M
┌────────▼──────────┐     ┌────────────────────────┐
│     products      │     │   product_variants     │
│───────────────────│     │────────────────────────│
│ id (PK)           │1   M│ id (PK)                │
│ tenant_id (FK)    │─────│ product_id (FK)        │
│ category_id (FK)  │     │ internal_sku (UNIQUE)  │
│ brand             │     │ name                   │
│ name              │     │ barcode                │
│ base_sku          │     │ variant_attributes(JSON│
│ unit              │     │ purchase_price         │
│ purchase_price    │     │ selling_price          │
│ selling_price     │     │ min_stock              │
│ min_stock         │     │ reorder_point          │
│ reorder_point     │     │ account_inventory      │
│ tax_purchase      │     │ account_sales          │
│ tax_sales         │     │ account_cogs           │
│ account_inventory │     │ account_return         │
│ account_sales     │     │ weight                 │
│ account_cogs      │     │ dimensions             │
│ account_return    │     │ is_active              │
│ description       │     │ created_at             │
│ image             │     │ updated_at             │
│ is_active         │     └────────────────────────┘
│ created_at        │
│ updated_at        │
└────────────────────┘

┌───────────────────┐
│    contacts       │
│───────────────────│
│ id (PK)           │
│ tenant_id (FK)    │
│ company_id (FK)   │
│ type              │── customer / supplier / employee / other
│ code              │
│ name              │
│ company_name      │
│ npwp              │
│ nik               │
│ email             │
│ phone             │
│ address           │
│ payment_term_days │
│ credit_limit      │
│ is_active         │
│ created_at        │
│ updated_at        │
└───────────────────┘
```

---

## C. Inventory

```
┌───────────────────┐
│   warehouses      │
│───────────────────│
│ id (PK)           │
│ tenant_id (FK)    │
│ company_id (FK)   │
│ branch_id (FK)    │
│ code              │
│ name              │
│ address           │
│ is_active         │
│ created_at        │
│ updated_at        │
└────────┬──────────┘
         │
         │
┌────────▼──────────────────┐
│   inventory_balances      │
│───────────────────────────│
│ id (PK)                   │
│ tenant_id (FK)            │
│ product_variant_id (FK)   │
│ warehouse_id (FK)         │
│ on_hand                   │
│ reserved                  │
│ available                 │── computed: on_hand - reserved
│ average_cost              │
│ last_purchase_cost        │
│ updated_at                │
└───────────────────────────┘

┌───────────────────────────┐
│   inventory_movements     │
│───────────────────────────│
│ id (PK)                   │
│ tenant_id (FK)            │
│ product_variant_id (FK)   │
│ warehouse_id (FK)         │
│ user_id (FK)              │
│ reference_type            │── Sale / Purchase / Transfer / Adjustment / Production
│ reference_id              │
│ quantity_in               │
│ quantity_out              │
│ quantity_before           │
│ quantity_after            │
│ unit_cost                 │
│ transaction_date          │
│ notes                     │
│ created_at                │
└───────────────────────────┘

┌───────────────────────────┐     ┌──────────────────────────┐
│   stock_transfers         │     │  stock_transfer_items    │
│───────────────────────────│     │──────────────────────────│
│ id (PK)                   │1   M│ id (PK)                  │
│ tenant_id (FK)            │─────│ transfer_id (FK)         │
│ company_id (FK)           │     │ product_variant_id (FK)  │
│ from_warehouse_id (FK)    │     │ quantity                 │
│ to_warehouse_id (FK)      │     │ notes                    │
│ transfer_no               │     └──────────────────────────┘
│ status                    │── Draft / Approved / In Transit / Received / Cancelled
│ approved_by (FK→users)    │
│ request_date              │
│ receive_date              │
│ notes                     │
│ created_at                │
│ updated_at                │
└───────────────────────────┘

┌───────────────────────────┐
│   stock_adjustments       │
│───────────────────────────│
│ id (PK)                   │
│ tenant_id (FK)            │
│ warehouse_id (FK)         │
│ product_variant_id (FK)   │
│ adjustment_type           │── In / Out / Lost / Damage / Reject / Correction / Return
│ quantity                  │
│ unit_cost                 │
│ reason                    │
│ user_id (FK)              │
│ approved_by (FK→users)    │
│ status                    │
│ created_at                │
│ updated_at                │
└───────────────────────────┘

┌───────────────────────────┐     ┌──────────────────────────┐
│   stock_opnames           │     │  stock_opname_items      │
│───────────────────────────│     │──────────────────────────│
│ id (PK)                   │1   M│ id (PK)                  │
│ tenant_id (FK)            │─────│ opname_id (FK)           │
│ warehouse_id (FK)         │     │ product_variant_id (FK)  │
│ opname_no                 │     │ system_qty               │
│ opname_date               │     │ physical_qty             │
│ status                    │     │ variance                 │
│ approved_by (FK→users)    │     │ unit_cost                │
│ notes                     │     │ notes                    │
│ created_at                │     └──────────────────────────┘
│ updated_at                │
└───────────────────────────┘
```

---

## D. Sales Module

```
┌───────────────────┐
│  sales_quotations │
│───────────────────│
│ id (PK)           │
│ tenant_id (FK)    │
│ company_id (FK)   │
│ customer_id (FK)  │── contacts
│ quotation_no      │
│ quotation_date    │
│ expiry_date       │
│ sales_id (FK)     │── users
│ branch_id (FK)    │
│ warehouse_id (FK) │
│ status            │── Draft / Sent / Accepted / Rejected / Expired / Converted
│ notes             │
│ subtotal          │
│ discount_total    │
│ tax_total         │
│ grand_total       │
│ created_at        │
│ updated_at        │
└──────┬────────────┘
       │ 1
       │ M
┌──────▼──────────────────┐
│ sales_quotation_items   │
│─────────────────────────│
│ id (PK)                 │
│ quotation_id (FK)       │
│ product_variant_id (FK) │
│ description             │
│ quantity                │
│ unit_price              │
│ discount_percent        │
│ discount_amount         │
│ tax_percent             │
│ tax_amount              │
│ subtotal                │
│ total                   │
└─────────────────────────┘

┌────────────────────┐
│   sales_orders     │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ customer_id (FK)   │
│ quotation_id (FK)  │── nullable, if converted
│ order_no           │
│ order_date         │
│ expected_date      │
│ sales_id (FK→users)│
│ branch_id (FK)     │
│ warehouse_id (FK)  │
│ channel            │
│ status             │── Draft / Confirmed / Partial / Completed / Cancelled
│ notes              │
│ subtotal           │
│ discount_total     │
│ tax_total          │
│ grand_total        │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → sales_order_items (same pattern as quotation items)

┌────────────────────┐
│  sales_deliveries  │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ sales_order_id (FK)│
│ delivery_no        │
│ delivery_date      │
│ warehouse_id (FK)  │
│ status             │── Draft / Delivered / Cancelled
│ notes              │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → sales_delivery_items

┌────────────────────┐
│  sales_invoices    │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ customer_id (FK)   │
│ sales_order_id (FK)│
│ invoice_no         │
│ invoice_date       │
│ due_date           │
│ sales_id (FK→users)│
│ branch_id (FK)     │
│ warehouse_id (FK)  │
│ channel            │
│ currency           │
│ reference          │
│ status             │── Draft / Open / Partial / Paid / Overdue / Void
│ subtotal           │
│ discount_total     │
│ tax_total          │
│ grand_total        │
│ paid_amount        │
│ outstanding        │
│ posted_at          │── timestamp when journal created
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → sales_invoice_items
       │ 1:M → sales_payments
       │ 1:M → sales_returns

┌────────────────────┐
│  sales_payments    │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ invoice_id (FK)    │
│ bank_account_id(FK)│
│ payment_no         │
│ payment_date       │
│ amount             │
│ method             │── Cash / Transfer / Giro / Other
│ reference          │
│ notes              │
│ posted_at          │
│ created_at         │
│ updated_at         │
└────────────────────┘

┌────────────────────┐
│  sales_returns     │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ invoice_id (FK)    │
│ return_no          │
│ return_date        │
│ warehouse_id (FK)  │
│ refund_type        │── Refund / Credit Note
│ status             │
│ notes              │
│ subtotal           │
│ posted_at          │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → sales_return_items
```

---

## E. Purchase Module

```
┌────────────────────┐
│  purchase_orders   │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ supplier_id (FK)   │── contacts
│ order_no           │
│ order_date         │
│ expected_delivery  │
│ warehouse_id (FK)  │
│ branch_id (FK)     │
│ currency           │
│ payment_term       │
│ status             │── Draft / Waiting Approval / Open / Partial / Completed / Closed
│ subtotal           │
│ discount_total     │
│ tax_total          │
│ grand_total        │
│ approved_by (FK)   │
│ notes              │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → purchase_order_items

┌────────────────────┐
│ purchase_receipts  │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ purchase_order_id  │
│ receipt_no         │
│ receipt_date       │
│ warehouse_id (FK)  │
│ status             │── Draft / Received / Cancelled
│ notes              │
│ posted_at          │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → purchase_receipt_items

┌────────────────────┐
│ purchase_invoices  │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ supplier_id (FK)   │
│ purchase_order_id  │
│ invoice_supplier_no│
│ invoice_date       │
│ due_date           │
│ warehouse_id (FK)  │
│ branch_id (FK)     │
│ reference_no       │
│ status             │── Draft / Open / Partial / Paid / Void
│ subtotal           │
│ discount_total     │
│ tax_total          │
│ grand_total        │
│ paid_amount        │
│ outstanding        │
│ posted_at          │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → purchase_invoice_items
       │ 1:M → purchase_payments
       │ 1:M → purchase_returns
```

---

## F. Cash, Bank & Expense

```
┌────────────────────┐
│  bank_accounts     │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ account_id (FK)    │── chart of accounts
│ bank_name          │
│ account_no         │
│ account_name       │
│ initial_balance    │
│ current_balance    │
│ is_active          │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → bank_transactions

┌────────────────────┐
│ bank_transactions  │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ bank_account_id    │
│ transaction_type   │── Receive / Send / Transfer In / Transfer Out
│ transaction_date   │
│ contact_id (FK)    │
│ account_id (FK)    │── COA
│ amount             │
│ memo               │
│ reference          │
│ reconciled         │
│ reconciled_at      │
│ attachment         │
│ posted_at          │
│ created_at         │
│ updated_at         │
└────────────────────┘

┌────────────────────┐
│    expenses        │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ expense_no         │
│ expense_date       │
│ payee              │
│ account_id (FK)    │── expense account from COA
│ amount             │
│ tax_amount         │
│ bank_account_id    │
│ branch_id (FK)     │
│ department         │
│ memo               │
│ attachment         │
│ posted_at          │
│ created_at         │
│ updated_at         │
└────────────────────┘
```

---

## G. Accounting Core

```
┌────────────────────┐
│    accounts        │  (Chart of Accounts)
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ code               │── e.g. "1-1001"
│ name               │── e.g. "Kas BCA"
│ category           │── Asset / Liability / Equity / Revenue / COGS / Expense / Other Income / Other Expense
│ parent_id (FK)     │── self-referencing for hierarchy
│ description        │
│ currency           │
│ is_active          │
│ is_locked          │── cannot post manual journal
│ opening_balance    │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → journal_entry_lines

┌────────────────────┐
│  journal_entries   │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ journal_no         │
│ journal_date       │
│ source_type        │── SalesInvoice / PurchaseInvoice / Payment / Manual / Production / Adjustment / Closing
│ source_id          │
│ reference          │
│ description        │
│ total_debit        │── must equal total_credit
│ total_credit       │
│ is_posted          │
│ posted_by (FK)     │
│ posted_at          │
│ period             │── YYYY-MM
│ created_by (FK)    │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M
┌──────▼─────────────┐
│journal_entry_lines │
│────────────────────│
│ id (PK)            │
│ journal_entry_id   │
│ account_id (FK)    │
│ description        │
│ debit              │
│ credit             │
│ contact_id (FK)    │── nullable, for AR/AP detail
│ created_at         │
└────────────────────┘

┌────────────────────┐
│  opening_balances  │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ account_id (FK)    │
│ balance_date       │
│ debit              │
│ credit             │
│ contact_id (FK)    │── for AR/AP opening
│ created_at         │
└────────────────────┘

┌────────────────────┐
│   lock_periods     │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ period             │── YYYY-MM
│ locked_by (FK)     │
│ locked_at          │
│ created_at         │
└────────────────────┘

┌────────────────────┐
│   closings         │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ period             │── YYYY-MM
│ status             │── Draft / Checked / Closed
│ bank_reconciled    │
│ stock_opname_done  │
│ depreciation_run   │
│ trial_balance_ok   │
│ closed_by (FK)     │
│ closed_at          │
│ created_at         │
│ updated_at         │
└────────────────────┘
```

---

## H. Fixed Assets

```
┌────────────────────┐
│  fixed_assets      │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ asset_code         │
│ name               │
│ category           │
│ acquisition_date   │
│ acquisition_cost   │
│ residual_value     │
│ useful_life_months │
│ depreciation_method│── Straight Line / Double Declining
│ asset_account_id (FK→accounts)      │
│ accum_depr_account_id (FK→accounts) │
│ expense_account_id (FK→accounts)    │
│ is_active          │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M
┌──────▼─────────────┐
│ asset_depreciations│
│────────────────────│
│ id (PK)            │
│ asset_id (FK)      │
│ period             │
│ depreciation_amount│
│ accumulated_amount │
│ book_value         │
│ journal_entry_id   │
│ run_date           │
│ created_at         │
└────────────────────┘
```

---

## I. Production

```
┌────────────────────┐
│  production_boms   │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ product_variant_id │── finished good
│ bom_no             │
│ version            │
│ expected_output    │── per batch
│ waste_percent      │
│ standard_labor_cost│
│ standard_overhead  │
│ is_active          │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M
┌──────▼─────────────┐
│  production_bom_   │
│      items         │
│────────────────────│
│ id (PK)            │
│ bom_id (FK)        │
│ product_variant_id │── raw material
│ quantity           │── per output unit
│ unit              │
│ notes              │
└────────────────────┘

┌────────────────────┐     ┌──────────────────────┐
│ production_orders  │     │    work_orders        │
│────────────────────│     │──────────────────────│
│ id (PK)            │1   M│ id (PK)              │
│ tenant_id (FK)     │─────│ production_order_id  │
│ company_id (FK)    │     │ work_order_no        │
│ order_no           │     │ stage               │── Cutting / Sewing / Finishing / QC / Packing
│ product_variant_id │     │ team                │
│ bom_id (FK)        │     │ operator            │
│ target_qty         │     │ start_date          │
│ start_date         │     │ end_date            │
│ due_date           │     │ target_qty          │
│ raw_warehouse_id   │     │ actual_qty          │
│ finished_warehouse │     │ reject_qty          │
│ status             │     │ rework_qty          │
│ actual_output_qty  │     │ status              │
│ created_at         │     │ notes               │
│ updated_at         │     │ created_at           │
└──────┬─────────────┘     │ updated_at           │
       │                   └──────────────────────┘
       │ 1:M
┌──────▼─────────────┐
│ material_requests  │
│────────────────────│
│ id (PK)            │
│ production_order_id│
│ request_no         │
│ request_date       │
│ warehouse_id (FK)  │
│ status             │
│ created_at         │
└──────┬─────────────┘
       │ 1:M → material_request_items

┌────────────────────┐
│ material_issues    │
│────────────────────│
│ id (PK)            │
│ material_request_id│
│ issue_no           │
│ issue_date         │
│ status             │
│ posted_at          │── creates stock movement + journal (Dr WIP, Cr Raw Material)
│ created_at         │
└──────┬─────────────┘
       │ 1:M → material_issue_items (product_variant_id, qty, unit_cost)

┌────────────────────┐
│ production_outputs │
│────────────────────│
│ id (PK)            │
│ production_order_id│
│ output_date        │
│ output_type        │── Good / Reject / Rework
│ product_variant_id │
│ quantity           │
│ unit_cost          │── actual HPP (for good output)
│ warehouse_id (FK)  │── where goods sent
│ posted_at          │── creates stock movement (Dr Finished Goods, Cr WIP)
│ created_at         │
└────────────────────┘

┌────────────────────┐
│ production_rejects │
│────────────────────│
│ id (PK)            │
│ production_order_id│
│ work_order_id (FK) │
│ reject_date        │
│ product_variant_id │
│ quantity           │
│ defect_reason      │── Jahitan Bolong / Kotor / Ukuran / Warna / Lainnya
│ warehouse_id (FK)  │── reject warehouse
│ notes              │
│ created_at         │
└────────────────────┘

┌────────────────────┐
│   piece_rates      │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ work_order_id (FK) │
│ operator_name      │
│ operation          │
│ quantity           │
│ rate_per_unit      │
│ total_amount       │
│ payment_date       │
│ posted_at          │── creates journal (Dr Production Labor, Cr Bank/Cash)
│ created_at         │
└────────────────────┘
```

---

## J. Marketplace

```
┌────────────────────┐
│ marketplace_imports│
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ marketplace        │── Shopee / TikTok / Lazada
│ warehouse_id (FK)  │
│ filename           │
│ total_orders       │
│ total_items        │
│ matched_count      │
│ unmatched_count    │
│ duplicate_count    │
│ imported_count     │
│ status             │── Uploaded / Matched / Previewed / Imported / Failed
│ imported_by (FK)   │
│ imported_at        │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M
┌──────▼─────────────┐
│ marketplace_orders │
│────────────────────│
│ id (PK)            │
│ import_id (FK)     │
│ order_no           │── from marketplace
│ order_date         │
│ order_status       │
│ marketplace_item_id│── unique for duplicate check
│ created_at         │
└──────┬─────────────┘
       │ 1:M
┌──────▼──────────────┐
│marketplace_order_   │
│     items           │
│─────────────────────│
│ id (PK)             │
│ order_id (FK)       │
│ marketplace_sku     │
│ product_name        │
│ variant             │
│ quantity            │
│ price               │
│ discount            │
│ total               │
│ internal_sku_match  │── FK to product_variants, nullable
│ match_status        │── Matched / Unmatched
│ created_at          │
└─────────────────────┘

┌──────────────────────────┐
│ marketplace_sku_mapping  │
│──────────────────────────│
│ id (PK)                  │
│ tenant_id (FK)           │
│ marketplace              │
│ marketplace_sku          │
│ product_variant_id (FK)  │
│ is_auto                  │── true if exact match
│ mapped_by (FK→users)     │
│ created_at               │
│ updated_at               │
└──────────────────────────┘
```

---

## K. Approval & Audit

```
┌────────────────────┐
│    approvals       │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │
│ approvable_type    │── SalesOrder / PurchaseOrder / Expense / Payment / Journal / Adjustment / Transfer
│ approvable_id      │
│ status             │── Draft / Submitted / Waiting / Approved / Rejected / Posted
│ submitted_by (FK)  │
│ submitted_at       │
│ approved_by (FK)   │
│ approved_at        │
│ rejected_reason    │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M
┌──────▼─────────────┐
│   approval_steps   │
│────────────────────│
│ id (PK)            │
│ approval_id (FK)   │
│ step_order         │── 1, 2, 3...
│ approver_id        │── FK to users
│ role_id (FK)       │
│ min_amount         │── threshold for this step
│ status             │── Pending / Approved / Rejected
│ decided_at         │
│ notes              │
└────────────────────┘

┌────────────────────┐
│   audit_logs       │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ user_id (FK)       │
│ action             │── Create / Update / Delete / Post / Approve / Reject / Login / Export
│ module             │── Sales / Purchase / Inventory / Production / Accounting / User / Settings
│ document_type      │── SalesInvoice / PurchaseOrder / Product / Journal
│ document_id        │
│ document_no        │
│ old_values (JSON)  │
│ new_values (JSON)  │
│ ip_address         │
│ user_agent         │
│ created_at         │
└────────────────────┘
```

---

## L. SaaS Tables

```
┌────────────────────────┐
│  subscription_plans    │
│────────────────────────│
│ id (PK)                │
│ name                   │── Starter / Pro / Business / Enterprise
│ code                   │
│ price_monthly          │
│ price_yearly           │
│ max_users              │
│ max_companies          │
│ max_branches           │
│ max_warehouses         │
│ features (JSON)        │── {"accounting":true,"inventory":true,"production":false,...}
│ is_active              │
│ created_at             │
│ updated_at             │
└──────┬─────────────────┘
       │ 1:M
┌──────▼─────────────────┐
│    subscriptions       │
│────────────────────────│
│ id (PK)                │
│ tenant_id (FK)         │
│ plan_id (FK)           │
│ start_date             │
│ end_date               │
│ status                 │── Trial / Active / Due / Grace / Suspended
│ auto_renew             │
│ created_at             │
│ updated_at             │
└──────┬─────────────────┘
       │ 1:M
┌──────▼─────────────────┐
│ subscription_invoices  │
│────────────────────────│
│ id (PK)                │
│ subscription_id (FK)   │
│ invoice_no             │
│ amount                 │
│ discount               │
│ tax                    │
│ total                  │
│ due_date               │
│ status                 │── Unpaid / Paid / Overdue / Cancelled
│ paid_at                │
│ created_at             │
│ updated_at             │
└──────┬─────────────────┘
       │ 1:M
┌──────▼─────────────────┐
│ subscription_payments  │
│────────────────────────│
│ id (PK)                │
│ invoice_id (FK)        │
│ amount                 │
│ method                 │
│ reference              │
│ paid_at                │
│ created_at             │
└────────────────────────┘

┌────────────────────┐
│   feature_flags    │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ feature_key        │── e.g. "production", "marketplace"
│ is_enabled         │
│ created_at         │
│ updated_at         │
└────────────────────┘

┌────────────────────┐
│ support_tickets    │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ user_id (FK)       │
│ subject            │
│ category           │
│ priority           │
│ assigned_to (FK)   │
│ status             │
│ created_at         │
│ updated_at         │
└──────┬─────────────┘
       │ 1:M → support_ticket_messages

┌────────────────────┐
│  announcements     │
│────────────────────│
│ id (PK)            │
│ title              │
│ content            │
│ target             │── All / Specific Tenant / Plan
│ target_id          │
│ is_active          │
│ published_at       │
│ created_at         │
└────────────────────┘

┌────────────────────┐
│  impersonations    │
│────────────────────│
│ id (PK)            │
│ superadmin_id (FK) │
│ tenant_id (FK)     │
│ user_id (FK)       │── target user impersonated
│ start_time         │
│ end_time           │
│ reason             │
│ activity_log (JSON)│
│ created_at         │
└────────────────────┘
```

---

## M. Settings Table

```
┌────────────────────┐
│    settings        │
│────────────────────│
│ id (PK)            │
│ tenant_id (FK)     │
│ company_id (FK)    │── nullable: NULL = tenant-level
│ module             │── Company / Sales / Purchase / Inventory / Production / Marketplace / Accounting / Tax / Notification
│ key                │
│ value              │
│ created_at         │
│ updated_at         │
└────────────────────┘
```

---

## Key Relationships Summary

| Parent | Child | Type |
|--------|-------|------|
| Tenant | Company, User, Contact, Product, all master data | 1:M |
| Company | Branch, Warehouse | 1:M |
| Product | ProductVariant | 1:M |
| ProductVariant | InventoryBalance (per warehouse) | 1:M |
| Warehouse | InventoryBalance, InventoryMovement | 1:M |
| SalesInvoice | SalesInvoiceItems, SalesPayments, SalesReturns | 1:M |
| PurchaseInvoice | PurchaseInvoiceItems, PurchasePayments, PurchaseReturns | 1:M |
| JournalEntry | JournalEntryLines | 1:M |
| Account (COA) | JournalEntryLines | 1:M |
| ProductionOrder | WorkOrder, MaterialRequest, ProductionOutput | 1:M |
| BOM | ProductionBomItems | 1:M |
| MarketplaceImport | MarketplaceOrder | 1:M |
| MarketplaceOrder | MarketplaceOrderItem | 1:M |
| SubscriptionPlan | Subscription | 1:M |
| Subscription | SubscriptionInvoice | 1:M |

Total: **~60 tables**, **~120 relationships**
