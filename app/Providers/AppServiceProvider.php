<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\LicenseClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Database\Eloquent\Relations\Relation::enforceMorphMap([
            'SalesInvoice' => \App\Models\SalesInvoice::class,
            'PurchaseOrder' => \App\Models\PurchaseOrder::class,
            'JournalEntry' => \App\Models\JournalEntry::class,
        ]);
    }
}
