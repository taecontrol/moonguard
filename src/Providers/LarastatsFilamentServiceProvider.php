<?php

namespace Taecontrol\Larastats\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Taecontrol\Larastats\Filament\Resources\SiteResource;

class LarastatsFilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        SiteResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('larastats');
    }
}
