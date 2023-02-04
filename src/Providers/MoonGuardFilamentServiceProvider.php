<?php

namespace Taecontrol\MoonGuard\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Taecontrol\MoonGuard\Filament\Resources\SiteResource;
use Taecontrol\MoonGuard\Filament\Widgets\SiteStatsWidget;
use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource;

class MoonGuardFilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        SiteResource::class,
        ExceptionLogResource::class,
    ];

    protected array $widgets = [
        SiteStatsWidget::class,
    ];

    protected array $styles = [
        'moonguard-styles' => __DIR__ . '/../../dist/css/plugin.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('moonguard');
    }
}
