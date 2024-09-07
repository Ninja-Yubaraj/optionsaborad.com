<?php

namespace App\Providers\Filament;

use App\Filament\User\Pages\Auth\ProfilePage;
use App\Filament\Widgets\SelectCountryWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('user')
            ->colors([
                'primary' => Color::hex('#14a5f7'),
            ])
            ->profile()
            ->brandLogo(fn () => view('filament.data.logo'))
            ->brandLogoHeight('140px')
            ->login()
            ->profile(ProfilePage::class,)
            ->spa()
            ->userMenuItems([
                MenuItem::make()
                    ->label(fn () => 'Dashboard')
                    ->icon('heroicon-o-arrow-left')
                    ->url(fn () => url('/user'))
            ])
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                SelectCountryWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
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
                \App\Http\Middleware\AutoDeactive::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->topNavigation(true)
            ->darkMode(false)
            ->renderHook(
                PanelsRenderHook::STYLES_BEFORE,
                fn () => view('styles'),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_AFTER,
                fn () => view('boxes'),
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_END,
                fn () => view('mobile-boxes'),
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_END,
                fn () => view('mobile-box-support'),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_AFTER,
                fn () => view('logo-change'),
            );
    }
}
