<?php

namespace Taecontrol\Larastats\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Taecontrol\Larastats\Filament\Resources\SiteResource;
use Taecontrol\Larastats\Filament\Widgets\SiteStatsWidget;
use Taecontrol\Larastats\Filament\Resources\ExceptionLogResource;

class LarastatsFilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        SiteResource::class,
        ExceptionLogResource::class,
    ];

    protected array $widgets = [
        SiteStatsWidget::class,
    ];

    protected array $styles = [
        'larastats-styles' => __DIR__ . '/../../dist/css/plugin.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('larastats');
    }
}
