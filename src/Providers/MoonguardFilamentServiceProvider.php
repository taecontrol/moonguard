<?php

namespace Taecontrol\Moonguard\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Taecontrol\Moonguard\Filament\Resources\SiteResource;
use Taecontrol\Moonguard\Filament\Widgets\SiteStatsWidget;
use Taecontrol\Moonguard\Filament\Resources\ExceptionLogResource;

class MoonguardFilamentServiceProvider extends PluginServiceProvider
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
