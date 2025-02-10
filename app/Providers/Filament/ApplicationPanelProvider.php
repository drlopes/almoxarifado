<?php

namespace App\Providers\Filament;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Yebor974\Filament\RenewPassword\RenewPasswordPlugin;
use Swis\Filament\Backgrounds\ImageProviders\Triangles;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\RememberTenantMiddleware;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Validation\Rules\Password;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Colors\Color;
use App\Filament\Pages\Dashboard;
use Filament\Enums\ThemeMode;
use Filament\PanelProvider;
use App\Models\Tenant;
use Filament\Panel;

class ApplicationPanelProvider extends PanelProvider
{
    public function panel(Panel $panel) : Panel
    {
        return $panel
            ->spa()
            ->login()
            ->default()
            ->path('')
            ->topNavigation()
            ->id('application')
            ->authGuard('web')
            ->defaultThemeMode(ThemeMode::Light)
            ->viteTheme('resources/css/filament/application/theme.css')
            ->favicon(env('APP_URL') . '/favicon.svg')
            ->brandLogo(fn () => view('components.app.logo'))
            ->brandName(config('app.name'))
            ->maxContentWidth(maxContentWidth: MaxWidth::Full)
            ->spaUrlExceptions(exceptions: fn () : array => $this->getSpaUrlExceptions())
            ->tenant(Tenant::class, 'code', 'tenants')
            ->tenantMiddleware([
                RememberTenantMiddleware::class,
            ], isPersistent: true)
            ->colors([
                'gray' => Color::Slate,
                'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(app_path('Filament/Widgets'), 'App\\Filament\\Widgets')
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
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                RenewPasswordPlugin::make()
                    ->passwordExpiresIn(days: 60)
                    ->forceRenewPassword(),
                BreezyCore::make()
                    ->myProfile()
                    ->passwordUpdateRules(rules: ['required', Password::defaults()], requiresCurrentPassword: true)
                    ->enableTwoFactorAuthentication(),
                LightSwitchPlugin::make(),
            ]);
    }

    private function getSpaUrlExceptions() : array
    {
        // When changing the tenant while on SPA mode, the links in the navigation bar
        // will not change accordingly. This method is used to tell Filament which URLs
        // should not be treated as SPA URLs, so that when the tenant is changed, the
        // navigation bar will be forced to reload with the correct links for the new tenant.
        // Ex:
        // return [
        //     route('filament.application.pages.dashboard', 'cddnpc'),
        // ];

        return [
            route('filament.application.pages.dashboard', 'dev'),
        ];
    }
}