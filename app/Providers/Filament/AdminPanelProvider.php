<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Pages\Login::class)
            ->brandName('GoERP')
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->font('Inter')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('15.5rem')
            ->collapsedSidebarWidth('4rem')
            ->topbar(true)
            ->navigationGroups([
                NavigationGroup::make('🏢 Perusahaan')->collapsed(false),
                NavigationGroup::make('📦 Master Data')->collapsed(false),
                NavigationGroup::make('💰 Penjualan')->collapsed(false),
                NavigationGroup::make('🛒 Pembelian')->collapsed(false),
                NavigationGroup::make('💵 Kas & Bank')->collapsed(true),
                NavigationGroup::make('📊 Akuntansi')->collapsed(true),
                NavigationGroup::make('🏭 Produksi')->collapsed(true),
                NavigationGroup::make('📈 Laporan')->collapsed(true),
                NavigationGroup::make('⚙️ Pengaturan')->collapsed(true),
                NavigationGroup::make('🔐 Approval & Audit')->collapsed(true),
                NavigationGroup::make('📝 Blog')->collapsed(true),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\SalesChart::class,
                \App\Filament\Widgets\RecentInvoices::class,
                \App\Filament\Widgets\CashierToday::class,
                \App\Filament\Widgets\WarehouseStockAlert::class,
                \App\Filament\Widgets\OverdueInvoices::class,
                \App\Filament\Widgets\TodaySales::class,
            ])
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn() => view('filament.components.language-switcher'),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
