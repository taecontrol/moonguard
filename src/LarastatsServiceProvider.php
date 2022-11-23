<?php

namespace Taecontrol\Larastats;

use Illuminate\Support\ServiceProvider;
use Taecontrol\Larastats\Console\Commands\CheckSslCertificateCommand;
use Taecontrol\Larastats\Console\Commands\CheckUptimeCommand;

class LarastatsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/larastats.php' => config_path('larastats.php')
        ], ['larastats-config']);

        if (! class_exists('CreateLarastatsTables')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_larastats_tables.php.stub' =>
                    database_path('migrations/'.date('Y_m_d_His', time()).'_create_larastats_tables.php')
            ], ['larastats-migrations']);
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckUptimeCommand::class,
                CheckSslCertificateCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/larastats.php', 'larastats');
    }
}
