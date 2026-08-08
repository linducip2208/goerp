<?php

namespace App\Filament\Admin\Pages;

use App\Models\Tenant;
use App\Models\Subscription;
use App\Models\SubscriptionInvoice;
use App\Models\SupportTicket;
use Filament\Facades\Filament;
use Filament\Pages\Page;

class PlatformOverview extends Page
{
    protected static ?string $navigationGroup = '🏠 Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'Platform Overview';

    protected static string $view = 'filament.pages.platform-overview';

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

    public function getStats(): array
    {
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();
        $trialTenants = Tenant::where('status', 'trial')->count();
        $expiredTenants = Tenant::where('status', 'expired')->count();
        $suspendedTenants = Tenant::where('status', 'suspended')->count();
        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $mrr = SubscriptionInvoice::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total');
        $outstandingBilling = SubscriptionInvoice::whereIn('status', ['unpaid', 'overdue'])->sum('total');
        $openTickets = SupportTicket::where('status', 'open')->count();

        $topTenants = Tenant::withCount('users')
            ->orderByDesc('users_count')
            ->take(5)
            ->get();

        $recentTickets = SupportTicket::with(['tenant', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return [
            'totalTenants' => $totalTenants,
            'activeTenants' => $activeTenants,
            'trialTenants' => $trialTenants,
            'expiredTenants' => $expiredTenants,
            'suspendedTenants' => $suspendedTenants,
            'totalSubscriptions' => $totalSubscriptions,
            'activeSubscriptions' => $activeSubscriptions,
            'mrr' => $mrr,
            'outstandingBilling' => $outstandingBilling,
            'openTickets' => $openTickets,
            'topTenants' => $topTenants,
            'recentTickets' => $recentTickets,
        ];
    }
}
