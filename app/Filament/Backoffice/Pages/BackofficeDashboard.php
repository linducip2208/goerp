<?php

namespace App\Filament\Backoffice\Pages;

use App\Models\Subscription;
use App\Models\SubscriptionInvoice;
use App\Models\Tenant;
use Filament\Pages\Page;

class BackofficeDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = '🏢 Pelanggan';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.backoffice.pages.backoffice-dashboard';

    protected static string $routePath = '/';

    public function getTitle(): string
    {
        return 'Dashboard Backoffice';
    }

    protected function getViewData(): array
    {
        return [
            'totalTenants' => Tenant::count(),
            'activeTenants' => Tenant::where('status', 'active')->count(),
            'trialTenants' => Tenant::where('status', 'trial')->count(),
            'mrr' => Subscription::where('status', 'active')
                ->join('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
                ->sum('subscription_plans.price_monthly'),
            'outstandingPayments' => SubscriptionInvoice::whereIn('status', ['unpaid', 'overdue'])->sum('total'),
            'totalSubscriptions' => Subscription::count(),
            'activeSubscriptions' => Subscription::where('status', 'active')->count(),
            'trialSubscriptions' => Subscription::where('status', 'trial')->count(),
        ];
    }
}
