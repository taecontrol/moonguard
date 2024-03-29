<?php

namespace Taecontrol\MoonGuard\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Taecontrol\MoonGuard\MoonGuardTheme;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Taecontrol\MoonGuard\Filament\Pages\Dashboard;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Taecontrol\MoonGuard\Filament\Resources\SiteResource;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Taecontrol\MoonGuard\Filament\Widgets\SiteStatsWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Widgets\CpuLoadChart;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Widgets\DiskSpaceChart;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Widgets\MemoryLoadChart;

class MoonGuardPanelProvider extends PanelProvider
{
    protected array $pages = [
        Dashboard::class,
    ];

    protected array $resources = [
        SiteResource::class,
        ExceptionLogResource::class,
        ServerMonitoringResource::class,
    ];

    protected array $widgets = [
        SiteStatsWidget::class,
        CpuLoadChart::class,
        DiskSpaceChart::class,
        MemoryLoadChart::class,
    ];

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('moonguard')
            ->path('moonguard')
            ->brandName('MoonGuard')
            ->login()
            ->passwordReset()
            ->pages($this->pages)
            ->resources($this->resources)
            ->widgets($this->widgets)
            ->colors([
                'primary' => Color::Slate,
            ])
            ->theme(new MoonGuardTheme('moonguard', 'css/vendor/moonguard/theme.css'))
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
