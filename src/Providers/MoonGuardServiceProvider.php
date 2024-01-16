<?php

namespace Taecontrol\MoonGuard\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Taecontrol\MoonGuard\Contracts\MoonGuardSite;
use Taecontrol\MoonGuard\Contracts\MoonGuardUser;
use Taecontrol\MoonGuard\Contracts\MoonGuardUptimeCheck;
use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLog;
use Taecontrol\MoonGuard\Console\Commands\CheckUptimeCommand;
use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;
use Taecontrol\MoonGuard\Contracts\MoonGuardSslCertificateCheck;
use Taecontrol\MoonGuard\Console\Commands\DeleteOldExceptionCommand;
use Taecontrol\MoonGuard\Console\Commands\DeleteSystemMetricCommand;
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
        $this->publishAssets();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/moonguard.php', 'moonguard');

        $this->app->register(EventServiceProvider::class);

        $this->app->bind(MoonGuardSite::class, config('moonguard.site.model'));
        $this->app->bind(MoonGuardUser::class, config('moonguard.user.model'));
        $this->app->bind(MoonGuardUptimeCheck::class, config('moonguard.uptime_check.model'));
        $this->app->bind(MoonGuardSslCertificateCheck::class, config('moonguard.ssl_certificate_check.model'));
        $this->app->bind(MoonGuardExceptionLog::class, config('moonguard.exceptions.exception_log.model'));
        $this->app->bind(MoonGuardExceptionLogGroup::class, config('moonguard.exceptions.exception_log_group.model'));
    }

    protected function publishConfigFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/moonguard.php' => config_path('moonguard.php'),
        ], ['moonguard-config']);
    }

    protected function getMigrationTimestamp(): string
    {
        sleep(2);

        return date('Y_m_d_His', time());
    }

    protected function publishMigrations(): void
    {
        if (! class_exists('CreateMoonGuardTables')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_moonguard_tables.php.stub' => database_path('migrations/' . $this->getMigrationTimestamp() . '_create_moonguard_tables.php'),
            ], ['moonguard-migrations']);
        }

        if (! class_exists('AddSMFieldsOnSitesTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/add_system_monitoring_fields_on_sites_table.php.stub' => database_path('migrations/' . $this->getMigrationTimestamp() . '_add_sm_fields_on_sites_table.php'),
            ], ['moonguard-migrations']);
        }
    }

    protected function publishCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckUptimeCommand::class,
                CheckSslCertificateCommand::class,
                DeleteOldExceptionCommand::class,
                DeleteSystemMetricCommand::class,
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

    protected function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../../dist/css' => public_path('css/vendor/moonguard'),
        ], 'moonguard-assets');
    }
}
