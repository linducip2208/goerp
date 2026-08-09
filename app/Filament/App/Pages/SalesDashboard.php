<?php

namespace App\Filament\App\Pages;

use App\Models\SalesInvoice;
use App\Models\SalesOrder;
use App\Models\SalesPayment;
use Filament\Pages\Page;

class SalesDashboard extends Page
{
    protected static ?string $navigationGroup = null;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?int $navigationSort = 999;
    protected static ?string $title = 'Dashboard Penjualan';

    protected static string $view = 'filament.pages.sales-dashboard';

    public function getStats(): array
    {
        return [
            'total_orders' => SalesOrder::count(),
            'total_invoices' => SalesInvoice::count(),
            'total_payments' => SalesPayment::sum('amount'),
            'pending_orders' => SalesOrder::whereIn('status', ['draft', 'confirmed'])->count(),
        ];
    }
}
