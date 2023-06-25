<?php

namespace Taecontrol\MoonGuard\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Taecontrol\MoonGuard\Filament\Resources\SiteResource;
use Taecontrol\MoonGuard\Filament\Widgets\SiteStatsWidget;
use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Taecontrol\MoonGuard\Filament\Pages\Dashboard;

class MoonGuardPanelProvider extends PanelProvider
{
    protected array $pages =[
        Dashboard::class,
    ];

    protected array $resources = [
        SiteResource::class,
        ExceptionLogResource::class,
    ];

    protected array $widgets = [
        SiteStatsWidget::class,
    ];

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('moonguard')
            ->path('moonguard')
            ->login()
            ->passwordReset()
            ->emailVerification()
            ->pages($this->pages)
            ->resources($this->resources)
            ->widgets($this->widgets)
            ->colors([
                'primary' => Color::Slate,
            ])
            ->renderHook('styles.end', function () {
                return view('moonguard::styles');
            })
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
