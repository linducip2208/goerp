<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Tenant;
use App\Models\Subscription;
use App\Models\SubscriptionInvoice;
use App\Models\SupportTicket;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlatformStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

    protected function getStats(): array
    {
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();
        $trialTenants = Tenant::where('status', 'trial')->count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $mrr = SubscriptionInvoice::where('status', 'paid')->whereMonth('created_at', now()->month)->sum('total');
        $outstandingBilling = SubscriptionInvoice::whereIn('status', ['unpaid', 'overdue'])->sum('total');
        $openTickets = SupportTicket::where('status', 'open')->count();

        return [
            Stat::make('Total Tenant', number_format($totalTenants))
                ->description("{$activeTenants} aktif, {$trialTenants} trial")
                ->icon('heroicon-o-building-office'),
            Stat::make('Langganan Aktif', number_format($activeSubscriptions))
                ->description('Subscription active')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('MRR Bulan Ini', 'Rp ' . number_format($mrr, 0, ',', '.'))
                ->description('Monthly Recurring Revenue')
                ->icon('heroicon-o-banknotes')
                ->color('info'),
            Stat::make('Outstanding', 'Rp ' . number_format($outstandingBilling, 0, ',', '.'))
                ->description('Tagihan belum dibayar')
                ->icon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Stat::make('Support Ticket', number_format($openTickets))
                ->description('Open tickets')
                ->icon('heroicon-o-chat-bubble-left')
                ->color($openTickets > 10 ? 'danger' : 'success'),
        ];
    }
}
