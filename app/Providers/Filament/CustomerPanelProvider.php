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

class CustomerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->login(\App\Filament\Pages\Login::class)
            ->brandName('GoERP')
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Sky,
                'gray' => Color::Slate,
            ])
            ->font('Inter')
            ->darkMode(true)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('16rem')
            ->collapsedSidebarWidth('4rem')
            ->topbar(true)
            ->navigationGroups([
                NavigationGroup::make('📊 Dashboard')->collapsed(false),
                NavigationGroup::make('📦 Produk & Inventori')->collapsed(false),
                NavigationGroup::make('💰 Penjualan')->collapsed(false),
                NavigationGroup::make('🛒 Pembelian')->collapsed(false),
                NavigationGroup::make('🏭 Manufaktur')->collapsed(true),
                NavigationGroup::make('💵 Keuangan')->collapsed(true),
                NavigationGroup::make('📖 Akuntansi')->collapsed(true),
                NavigationGroup::make('🏦 Aset')->collapsed(true),
                NavigationGroup::make('📈 Laporan')->collapsed(true),
                NavigationGroup::make('⚙️ Pengaturan')->collapsed(true),
            ])
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([
                \App\Filament\App\Widgets\StatsOverview::class,
                \App\Filament\App\Widgets\SalesChart::class,
                \App\Filament\App\Widgets\OverdueInvoices::class,
                \App\Filament\App\Widgets\TodaySales::class,
                \App\Filament\App\Widgets\RecentInvoices::class,
                \App\Filament\App\Widgets\WarehouseStockAlert::class,
            ])
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn() => view('filament.components.notification-bell'),
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
                \App\Http\Middleware\EnsureCustomerAccess::class,
            ]);
    }
}
