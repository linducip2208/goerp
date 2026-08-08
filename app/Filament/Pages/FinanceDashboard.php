<?php

namespace App\Filament\Pages;

use App\Models\Account;
use App\Models\Expense;
use App\Models\JournalEntry;
use App\Models\SalesPayment;
use Filament\Pages\Page;

class FinanceDashboard extends Page
{
    protected static ?string $navigationGroup = '🏠 Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 4;
    protected static ?string $title = 'Dashboard Keuangan';

    protected static string $view = 'filament.pages.finance-dashboard';

    public function getStats(): array
    {
        return [
            'total_revenue' => SalesPayment::sum('amount'),
            'total_expenses' => Expense::sum('amount'),
            'journal_entries' => JournalEntry::count(),
            'accounts' => Account::count(),
        ];
    }
}
