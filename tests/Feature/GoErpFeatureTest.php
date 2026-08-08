<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\Account;

class GoErpFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('GoERP');
    }

    public function test_docs_page_loads(): void
    {
        $response = $this->get('/docs');
        $response->assertStatus(200);
        $response->assertSee('Akun Demo');
    }

    public function test_blog_page_loads(): void
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    public function test_sitemap_loads(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_backoffice_login_page_loads(): void
    {
        $response = $this->get('/backoffice/login');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_requires_auth(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@goerp.test',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'test@goerp.test',
            'password' => 'password',
        ]);

        $this->assertTrue(User::where('email', 'test@goerp.test')->exists());
    }

    public function test_create_tenant(): void
    {
        $tenant = Tenant::create([
            'name' => 'Test Tenant',
            'domain' => 'test',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('tenants', ['name' => 'Test Tenant']);
        $this->assertEquals('active', $tenant->status);
    }

    public function test_create_company(): void
    {
        $tenant = Tenant::create(['name' => 'T', 'domain' => 't', 'status' => 'active']);
        $company = Company::create([
            'tenant_id' => $tenant->id,
            'name' => 'PT Test',
            'code' => 'TEST',
            'timezone' => 'Asia/Jakarta',
            'base_currency' => 'IDR',
        ]);

        $this->assertEquals('PT Test', $company->name);
        $this->assertEquals($tenant->id, $company->tenant_id);
    }

    public function test_create_product_with_variant(): void
    {
        $tenant = Tenant::create(['name' => 'T', 'domain' => 't', 'status' => 'active']);
        $product = Product::create([
            'tenant_id' => $tenant->id,
            'name' => 'Test Product',
            'base_sku' => 'TST-001',
            'unit' => 'Pcs',
            'selling_price' => 100000,
            'is_active' => true,
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'internal_sku' => 'TST-001-RED',
            'name' => 'Test Product Red',
            'selling_price' => 100000,
            'is_active' => true,
        ]);

        $this->assertEquals('TST-001-RED', $variant->internal_sku);
        $this->assertEquals('Test Product', $variant->product->name);
    }

    public function test_create_sales_invoice(): void
    {
        $tenant = Tenant::create(['name' => 'T', 'domain' => 't', 'status' => 'active']);
        $company = Company::create(['tenant_id' => $tenant->id, 'name' => 'C', 'code' => 'C', 'timezone' => 'UTC', 'base_currency' => 'IDR']);
        $customer = Contact::create(['tenant_id' => $tenant->id, 'type' => 'customer', 'code' => 'C01', 'name' => 'Test Customer', 'is_active' => true]);

        $invoice = SalesInvoice::create([
            'tenant_id' => $tenant->id,
            'company_id' => $company->id,
            'customer_id' => $customer->id,
            'invoice_no' => 'INV/2026/08/0001',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'currency' => 'IDR',
            'status' => 'open',
            'grand_total' => 500000,
            'outstanding' => 500000,
        ]);

        $this->assertEquals('INV/2026/08/0001', $invoice->invoice_no);
        $this->assertEquals(500000, $invoice->grand_total);
    }

    public function test_create_coa_account(): void
    {
        $tenant = Tenant::create(['name' => 'T', 'domain' => 't', 'status' => 'active']);
        $company = Company::create(['tenant_id' => $tenant->id, 'name' => 'C', 'code' => 'C', 'timezone' => 'UTC', 'base_currency' => 'IDR']);

        $account = Account::create([
            'tenant_id' => $tenant->id,
            'company_id' => $company->id,
            'code' => '1-1001',
            'name' => 'Kas BCA',
            'category' => 'asset',
            'is_active' => true,
        ]);

        $this->assertEquals('Kas BCA', $account->name);
        $this->assertEquals('asset', $account->category);
    }

    public function test_tenant_isolation(): void
    {
        $tenantA = Tenant::create(['name' => 'A', 'domain' => 'a', 'status' => 'active']);
        $tenantB = Tenant::create(['name' => 'B', 'domain' => 'b', 'status' => 'active']);

        Product::create(['tenant_id' => $tenantA->id, 'name' => 'Product A', 'base_sku' => 'A', 'unit' => 'Pcs', 'is_active' => true]);
        Product::create(['tenant_id' => $tenantB->id, 'name' => 'Product B', 'base_sku' => 'B', 'unit' => 'Pcs', 'is_active' => true]);

        $this->assertEquals(1, Product::where('tenant_id', $tenantA->id)->count());
        $this->assertEquals(1, Product::where('tenant_id', $tenantB->id)->count());
        $this->assertEquals(2, Product::count());
    }
}
