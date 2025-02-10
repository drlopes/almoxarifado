<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use BezhanSalleh\FilamentShield\FilamentShield;
use Filament\Support\Facades\FilamentView;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use App\Policies\TenantPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Filament\Tables\Table;
use App\Models\Tenant;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        // TODO: Remove this as soon as possible! Huge security risk! This is a temporary fix for the livewire upload file issue
        // as described in https://github.com/livewire/livewire/discussions/3084
        // Uncomment when serving application through external link if no solution has been found
        // $checkValidSignature = (config('app.env') === 'production' && str_contains(\URL::current(), 'livewire/upload-file'));
        // \Request::macro('hasValidSignature', function ($absolute = true) use ($checkValidSignature) {
        //     if ($checkValidSignature) {
        //         return true;
        //     }
        //     return \URL::hasValidSignature($this, $absolute);

        // });
        // \Request::macro('hasValidRelativeSignature', function () use ($checkValidSignature) {
        //     if ($checkValidSignature) {
        //         return true;
        //     }
        //     return \URL::hasValidSignature($this, $absolute = false);
        // });
        // \Request::macro('hasValidSignatureWhileIgnoring', function ($ignoreQuery = [], $absolute = true) use ($checkValidSignature) {
        //     if ($checkValidSignature) {
        //         return true;
        //     }
        //     return \URL::hasValidSignature($this, $absolute, $ignoreQuery);
        // });

        // Define default password rules
        Password::defaults(function () : Password {
            return Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

        // Prohibit destructive commands in prod
        FilamentShield::prohibitDestructiveCommands($this->app->isProduction());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        // Prevent model lazy loading
        Model::preventLazyLoading(! app()->isProduction());

        //  Register the application's policies
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Tenant::class, TenantPolicy::class);

        // Set the default pagination page option for all filament tables
        Table::configureUsing(function (Table $table) : void {
            $table->defaultPaginationPageOption(5);
        });

        // Register the admin menu component on the filament render hook
        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            fn () : string => Blade::render('<x-admin-menu />'),
        );

        // register language-switch plugin
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['pt_BR', 'en', 'fr'])
                ->visible(insidePanels: true, outsidePanels: true)
                ->outsidePanelRoutes(
                    [
                        'filament.application.auth.login',
                        'filament.application.auth.password.renew',
                    ]
                )
                ->flags([
                    'pt_BR' => asset('images/flags/brazil.svg'),
                    'en' => asset('images/flags/usa.svg'),
                    'fr' => asset('images/flags/france.svg'),
                ]);
        });

        // force HTTPS in production
        // Uncomment when serving application through external link
        // if ($this->app->environment('production')) {
        //     \URL::forceScheme('https');

        //     // Set the request scheme to HTTPS so filament SPA mode works
        //     $this->app['request']->server->set('HTTPS', 'on');
        // }
    }
}
