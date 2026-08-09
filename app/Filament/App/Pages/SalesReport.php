<?php

namespace App\Filament\App\Pages;

use App\Models\Branch;
use App\Models\Contact;
use App\Models\ProductVariant;
use App\Models\SalesInvoice;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class SalesReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = '📈 Laporan';
    protected static ?int $navigationSort = 13;
    protected static ?string $title = 'Laporan Penjualan';

    protected static string $view = 'filament.pages.sales-report';

    public ?array $data = [];
    public array $invoices = [];
    public array $summary = [];

    public function mount(): void
    {
        $this->form->fill([
            'date_from' => Carbon::now()->startOfMonth()->format('Y-m-d'),
            'date_to' => Carbon::now()->format('Y-m-d'),
        ]);

        $this->calculate();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)
                    ->schema([
                        DatePicker::make('date_from')
                            ->label('Dari')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                        DatePicker::make('date_to')
                            ->label('Sampai')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                        Select::make('customer_id')
                            ->label('Customer')
                            ->options(Contact::where('tenant_id', auth()->user()->tenant_id)
                                ->where('company_id', auth()->user()->company_id)
                                ->where('contact_type', 'customer')
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                        Select::make('product_variant_id')
                            ->label('Produk')
                            ->options(ProductVariant::query()
                                ->whereHas('product', function ($q) {
                                    $q->where('tenant_id', auth()->user()->tenant_id);
                                })
                                ->pluck('internal_sku', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                        Select::make('branch_id')
                            ->label('Cabang')
                            ->options(Branch::where('tenant_id', auth()->user()->tenant_id)
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                    ]),
            ])
            ->statePath('data');
    }

    public function calculate(): void
    {
        $tenantId = auth()->user()->tenant_id;
        $companyId = auth()->user()->company_id;
        $dateFrom = $this->data['date_from'] ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $dateTo = $this->data['date_to'] ?? Carbon::now()->format('Y-m-d');

        $query = SalesInvoice::query()
            ->where('tenant_id', $tenantId)
            ->where('company_id', $companyId)
            ->whereBetween('invoice_date', [$dateFrom, $dateTo])
            ->with('customer', 'branch', 'sales', 'items.productVariant');

        if (!empty($this->data['customer_id'])) {
            $query->where('customer_id', $this->data['customer_id']);
        }
        if (!empty($this->data['branch_id'])) {
            $query->where('branch_id', $this->data['branch_id']);
        }
        if (!empty($this->data['product_variant_id'])) {
            $query->whereHas('items', function ($q) {
                $q->where('product_variant_id', $this->data['product_variant_id']);
            });
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->get();

        $this->invoices = $invoices->toArray();

        $this->summary = [
            'total_invoices' => $invoices->count(),
            'total_items' => $invoices->sum(fn($i) => $i->items->count()),
            'total_revenue' => $invoices->sum('grand_total'),
            'total_paid' => $invoices->sum('paid_amount'),
            'total_outstanding' => $invoices->sum('outstanding'),
        ];
    }
}
