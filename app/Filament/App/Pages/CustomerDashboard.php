<?php

namespace App\Filament\App\Pages;

use App\Models\Contact;
use App\Models\SalesInvoice;
use App\Models\SalesOrder;
use Filament\Pages\Page;

class CustomerDashboard extends Page
{
    protected static ?string $navigationGroup = '🏠 Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 3;
    protected static ?string $title = 'Dashboard Customer';

    protected static string $view = 'filament.pages.customer-dashboard';

    public function getStats(): array
    {
        return [
            'total_customers' => Contact::count(),
            'active_orders' => SalesOrder::whereIn('status', ['draft', 'confirmed', 'processing'])->count(),
            'total_invoices' => SalesInvoice::count(),
        ];
    }
}
