<?php

namespace App\Filament\App\Widgets;

use App\Models\SalesInvoice;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodaySales extends BaseWidget
{
    use DashboardWidgetFilter;

    protected static ?int $sort = 7;

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'app' && static::isVisibleToRole(auth()->user()?->role);
    }

    protected static function isVisibleToRole(?string $role): bool
    {
        return in_array($role, ['sales', 'admin', 'owner']);
    }

    protected function getStats(): array
    {
        $todayInvoices = SalesInvoice::whereDate('invoice_date', today())
            ->where('status', '!=', 'draft');

        $totalPenjualan = $todayInvoices->sum('grand_total');
        $totalFaktur = $todayInvoices->count();
        $totalPaid = SalesInvoice::whereDate('invoice_date', today())
            ->where('status', 'paid')
            ->sum('paid_amount');

        return [
            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($totalPenjualan, 0, ',', '.'))
                ->description('Total nilai penjualan')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
            Stat::make('Faktur Hari Ini', number_format($totalFaktur))
                ->description('Jumlah faktur')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
            Stat::make('Pembayaran Hari Ini', 'Rp ' . number_format($totalPaid, 0, ',', '.'))
                ->description('Total dibayar')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary'),
        ];
    }
}
