<?php

namespace App\Filament\App\Pages;

use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;
use App\Models\TaxRate;
use Carbon\Carbon;
use Filament\Pages\Page;

class TaxReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = '📈 Laporan';
    protected static ?int $navigationSort = 17;
    protected static ?string $title = 'Laporan Pajak';

    protected static string $view = 'filament.pages.reports.tax';

    public array $taxData = [];
    public float $totalOutputTax = 0;
    public float $totalInputTax = 0;
    public float $netTax = 0;

    public function mount(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        $salesTax = SalesInvoice::where('status', '!=', 'draft')
            ->whereMonth('invoice_date', $now->month)
            ->whereYear('invoice_date', $now->year)
            ->where('tax_total', '>', 0)
            ->get()
            ->groupBy('tax_rate')
            ->map(fn($group) => $group->sum('tax_total'));

        $purchaseTax = PurchaseInvoice::where('status', '!=', 'draft')
            ->whereMonth('invoice_date', $now->month)
            ->whereYear('invoice_date', $now->year)
            ->where('tax_total', '>', 0)
            ->get()
            ->groupBy('tax_rate')
            ->map(fn($group) => $group->sum('tax_total'));

        $taxRates = TaxRate::pluck('name', 'rate')->toArray();

        $this->totalOutputTax = $salesTax->sum();
        $this->totalInputTax = $purchaseTax->sum();
        $this->netTax = $this->totalOutputTax - $this->totalInputTax;

        $allRates = collect(array_keys($taxRates))
            ->merge($salesTax->keys())
            ->merge($purchaseTax->keys())
            ->unique()
            ->sort();

        $this->taxData = [];
        foreach ($allRates as $rate) {
            $this->taxData[] = [
                'rate' => $rate . '%',
                'rate_name' => $taxRates[$rate] ?? ('PPN ' . $rate . '%'),
                'output' => $salesTax->get($rate, 0),
                'input' => $purchaseTax->get($rate, 0),
            ];
        }
    }
}
