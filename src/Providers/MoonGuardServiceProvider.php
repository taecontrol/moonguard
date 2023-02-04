<?php

namespace Taecontrol\MoonGuard\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Taecontrol\MoonGuard\Console\Commands\CheckUptimeCommand;
use Taecontrol\MoonGuard\Console\Commands\CheckSslCertificateCommand;

class MoonGuardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishConfigFiles();
        $this->publishMigrations();
        $this->publishCommands();
        $this->publishRoutes();
        $this->publishViews();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/moonguard.php', 'moonguard');

        $this->app->register(EventServiceProvider::class);
    }

    protected function publishConfigFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/moonguard.php' => config_path('moonguard.php'),
        ], ['moonguard-config']);
    }

    protected function publishMigrations(): void
    {
        if (! class_exists('CreateMoonGuardTables')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_moonguard_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_moonguard_tables.php'),
            ], ['moonguard-migrations']);
        }
    }

    protected function publishCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckUptimeCommand::class,
                CheckSslCertificateCommand::class,
            ]);
        }
    }

    protected function publishRoutes(): void
    {
        $routesConfiguration = [
            'prefix' => config('moonguard.routes.prefix'),
            'middleware' => config('moonguard.routes.middleware'),
        ];

        Route::group($routesConfiguration, function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        });
    }

    protected function publishViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'moonguard');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/moonguard'),
        ], 'moonguard-views');
    }
}
