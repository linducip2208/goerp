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
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Sky,
                'gray' => Color::Stone,
            ])
            ->font('Inter')
            ->darkMode(true)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('15.5rem')
            ->collapsedSidebarWidth('4rem')
            ->topbar(true)
            ->navigationGroups([
                NavigationGroup::make('🏠 Dashboard')->collapsed(false),
                NavigationGroup::make('🏢 Organisasi')->collapsed(false),
                NavigationGroup::make('📚 Master Data')->collapsed(false),
                NavigationGroup::make('👥 CRM')->collapsed(true),
                NavigationGroup::make('💰 Penjualan')->collapsed(true),
                NavigationGroup::make('🛒 Pembelian')->collapsed(true),
                NavigationGroup::make('📦 Inventory')->collapsed(true),
                NavigationGroup::make('🏭 Warehouse')->collapsed(true),
                NavigationGroup::make('🏭 Manufacturing')->collapsed(true),
                NavigationGroup::make('💵 Finance')->collapsed(true),
                NavigationGroup::make('📊 Accounting')->collapsed(true),
                NavigationGroup::make('🧾 Tax')->collapsed(true),
                NavigationGroup::make('🏦 Asset')->collapsed(true),
                NavigationGroup::make('🛒 Marketplace')->collapsed(true),
                NavigationGroup::make('📈 Reports')->collapsed(true),
                NavigationGroup::make('🔄 Workflow')->collapsed(true),
                NavigationGroup::make('🔐 Security & Audit')->collapsed(true),
                NavigationGroup::make('🔌 Integrations')->collapsed(true),
                NavigationGroup::make('🤖 AI')->collapsed(true),
                NavigationGroup::make('📥 Import / Export')->collapsed(true),
                NavigationGroup::make('⚙️ Settings')->collapsed(true),
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
                \App\Filament\App\Widgets\RecentInvoices::class,
                \App\Filament\App\Widgets\CashierToday::class,
                \App\Filament\App\Widgets\WarehouseStockAlert::class,
                \App\Filament\App\Widgets\OverdueInvoices::class,
                \App\Filament\App\Widgets\TodaySales::class,
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
