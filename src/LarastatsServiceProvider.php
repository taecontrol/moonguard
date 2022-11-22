<?php

namespace Taecontrol\Larastats;

use Illuminate\Support\ServiceProvider;

class LarastatsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/larastats.php' => config_path('larastats.php')
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/larastats.php', 'larastats');
    }
}
