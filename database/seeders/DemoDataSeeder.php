<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Warehouse;
use App\Models\Contact;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Account;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(
            ['domain' => 'demo'],
            ['name' => 'Demo Company', 'status' => 'active']
        );

        $company = Company::firstOrCreate(
            ['code' => 'DEMO'],
            [
                'tenant_id' => $tenant->id, 'name' => 'PT Demo Indonesia',
                'address' => 'Jakarta', 'phone' => '021-5555', 'email' => 'demo@goerp.test',
                'timezone' => 'Asia/Jakarta', 'date_format' => 'd/m/Y', 'fiscal_year_start' => 1,
                'base_currency' => 'IDR',
            ]
        );

        $branch = Branch::firstOrCreate(
            ['company_id' => $company->id, 'code' => 'JKT'],
            ['name' => 'Jakarta Pusat', 'address' => 'Jl. Thamrin', 'is_active' => true]
        );

        $warehouse = Warehouse::firstOrCreate(
            ['tenant_id' => $tenant->id, 'company_id' => $company->id, 'code' => 'GD-01'],
            ['branch_id' => $branch->id, 'name' => 'Gudang Utama', 'is_active' => true]
        );
        $onlineWarehouse = Warehouse::firstOrCreate(
            ['tenant_id' => $tenant->id, 'company_id' => $company->id, 'code' => 'GD-02'],
            ['branch_id' => $branch->id, 'name' => 'Gudang Online', 'is_active' => true]
        );

        $branch->update(['default_warehouse_id' => $warehouse->id]);

        $cat1 = ProductCategory::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Fashion']
        );
        $cat2 = ProductCategory::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Elektronik']
        );

        $p1 = Product::firstOrCreate(
            ['tenant_id' => $tenant->id, 'base_sku' => 'KYORI'],
            ['category_id' => $cat1->id, 'brand' => 'Kyori', 'name' => 'Kyori Bow Layer Top', 'unit' => 'Pcs', 'purchase_price' => 45000, 'selling_price' => 65000, 'min_stock' => 10, 'is_active' => true]
        );
        ProductVariant::firstOrCreate(['product_id' => $p1->id, 'internal_sku' => 'KYORI-SP-S'], ['name' => 'Soft Pink S', 'purchase_price' => 45000, 'selling_price' => 65000, 'min_stock' => 10, 'is_active' => true]);
        ProductVariant::firstOrCreate(['product_id' => $p1->id, 'internal_sku' => 'KYORI-SP-M'], ['name' => 'Soft Pink M', 'purchase_price' => 45000, 'selling_price' => 65000, 'min_stock' => 10, 'is_active' => true]);
        ProductVariant::firstOrCreate(['product_id' => $p1->id, 'internal_sku' => 'KYORI-BLK-S'], ['name' => 'Black S', 'purchase_price' => 45000, 'selling_price' => 65000, 'min_stock' => 5, 'is_active' => true]);

        $p2 = Product::firstOrCreate(
            ['tenant_id' => $tenant->id, 'base_sku' => 'SGA54'],
            ['category_id' => $cat2->id, 'brand' => 'Samsung', 'name' => 'Samsung Galaxy A54', 'unit' => 'Unit', 'purchase_price' => 4500000, 'selling_price' => 5500000, 'min_stock' => 5, 'is_active' => true]
        );
        ProductVariant::firstOrCreate(['product_id' => $p2->id, 'internal_sku' => 'SGA54-BLK'], ['name' => 'Awesome Black', 'purchase_price' => 4500000, 'selling_price' => 5500000, 'min_stock' => 3, 'is_active' => true]);

        $contacts = [
            ['tenant_id' => $tenant->id, 'company_id' => $company->id, 'type' => 'customer', 'code' => 'CUST-001', 'name' => 'Budi Santoso', 'company_name' => 'Toko Maju Jaya', 'phone' => '08123456789', 'is_active' => true],
            ['tenant_id' => $tenant->id, 'company_id' => $company->id, 'type' => 'customer', 'code' => 'CUST-002', 'name' => 'Siti Rahayu', 'company_name' => 'Butik Rahayu', 'phone' => '087654321', 'is_active' => true],
            ['tenant_id' => $tenant->id, 'company_id' => $company->id, 'type' => 'supplier', 'code' => 'SUP-001', 'name' => 'PT Garment Indo', 'company_name' => 'PT Garment Indonesia', 'phone' => '021-1111', 'is_active' => true],
            ['tenant_id' => $tenant->id, 'company_id' => $company->id, 'type' => 'supplier', 'code' => 'SUP-002', 'name' => 'PT Elektronik Jaya', 'phone' => '021-2222', 'is_active' => true],
        ];
        foreach ($contacts as $c) {
            Contact::firstOrCreate(['tenant_id' => $c['tenant_id'], 'company_id' => $c['company_id'], 'code' => $c['code']], $c);
        }

        $coa = [
            ['code' => '1-1001', 'name' => 'Kas BCA', 'category' => 'asset'],
            ['code' => '1-1002', 'name' => 'Kas Mandiri', 'category' => 'asset'],
            ['code' => '1-2001', 'name' => 'Piutang Usaha', 'category' => 'asset'],
            ['code' => '1-3001', 'name' => 'Persediaan Barang Dagang', 'category' => 'asset'],
            ['code' => '2-1001', 'name' => 'Hutang Usaha', 'category' => 'liability'],
            ['code' => '2-1002', 'name' => 'PPN Keluaran', 'category' => 'liability'],
            ['code' => '3-1001', 'name' => 'Modal Disetor', 'category' => 'equity'],
            ['code' => '4-1001', 'name' => 'Penjualan', 'category' => 'revenue'],
            ['code' => '5-1001', 'name' => 'Harga Pokok Penjualan', 'category' => 'cogs'],
            ['code' => '6-1001', 'name' => 'Beban Gaji', 'category' => 'expense'],
            ['code' => '6-1002', 'name' => 'Beban Sewa', 'category' => 'expense'],
            ['code' => '6-1003', 'name' => 'Beban Listrik & Internet', 'category' => 'expense'],
            ['code' => '6-1004', 'name' => 'Beban Transportasi', 'category' => 'expense'],
        ];
        foreach ($coa as $a) {
            Account::firstOrCreate(
                ['company_id' => $company->id, 'code' => $a['code']],
                ['tenant_id' => $tenant->id, 'name' => $a['name'], 'category' => $a['category'], 'is_active' => true]
            );
        }

        // Create admin user (idempotent — akan selalu ada setelah seed)
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@goerp.test'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'tenant_id' => $tenant->id,
                'company_id' => $company->id,
                'role' => 'admin',
            ]
        );
        if (!$admin->tenant_id) {
            $admin->update(['tenant_id' => $tenant->id, 'company_id' => $company->id, 'role' => 'admin']);
        }

        \App\Models\User::where('email', '!=', 'admin@goerp.test')->update(['tenant_id' => $tenant->id, 'company_id' => $company->id]);

        $plan = \App\Models\SubscriptionPlan::firstOrCreate(
            ['code' => 'enterprise'],
            [
                'name' => 'Enterprise',
                'price_monthly' => 2999000,
                'price_yearly' => 29990000,
                'max_users' => 999,
                'max_companies' => 999,
                'max_branches' => 999,
                'max_warehouses' => 999,
                'features' => json_encode(['accounting','inventory','sales','purchase','production','marketplace','multi_warehouse','approval','api','ai','reports']),
                'is_active' => true,
            ]
        );

        \App\Models\Subscription::firstOrCreate(
            ['tenant_id' => $tenant->id],
            [
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'status' => 'active',
                'auto_renew' => true,
            ]
        );
    }
}
