<?php

namespace Taecontrol\Larastats\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Taecontrol\Larastats\Console\Commands\CheckSslCertificateCommand;
use Taecontrol\Larastats\Console\Commands\CheckUptimeCommand;

class LarastatsServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/../../config/larastats.php', 'larastats');
    }

    protected function publishConfigFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/larastats.php' => config_path('larastats.php')
        ], ['larastats-config']);
    }

    protected function publishMigrations(): void
    {
        if (!class_exists('CreateLarastatsTables')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_larastats_tables.php.stub' =>
                    database_path('migrations/' . date('Y_m_d_His', time()) . '_create_larastats_tables.php')
            ], ['larastats-migrations']);
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
            'prefix' => config('larastats.routes.prefix'),
            'middleware' => config('larastats.routes.middleware'),
        ];

        Route::group($routesConfiguration, function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        });
    }

    protected function publishViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'larastats');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/larastats'),
        ], 'larastats-views');
    }
}
