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
            ->brandName('GoERP Platform')
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
                NavigationGroup::make('👥 Customers')->collapsed(false),
                NavigationGroup::make('🏢 Tenants')->collapsed(false),
                NavigationGroup::make('💳 Subscriptions')->collapsed(true),
                NavigationGroup::make('💰 Billing')->collapsed(true),
                NavigationGroup::make('📊 Usage')->collapsed(true),
                NavigationGroup::make('🎫 Support')->collapsed(true),
                NavigationGroup::make('📢 Announcements')->collapsed(true),
                NavigationGroup::make('🔐 Security')->collapsed(true),
                NavigationGroup::make('🛠️ System')->collapsed(true),
                NavigationGroup::make('🔌 Platform Integrations')->collapsed(true),
                NavigationGroup::make('⚙️ Platform Settings')->collapsed(true),
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                \App\Filament\Admin\Widgets\PlatformStatsOverview::class,
                \App\Filament\Admin\Widgets\NewTenantsWidget::class,
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
                \App\Http\Middleware\EnsurePlatformAccess::class,
            ]);
    }
}
