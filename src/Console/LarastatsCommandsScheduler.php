<?php

namespace Taecontrol\Larastats\Console;

use Illuminate\Console\Scheduling\Schedule;
use Taecontrol\Larastats\Console\Commands\CheckUptimeCommand;
use Taecontrol\Larastats\Console\Commands\CheckSslCertificateCommand;

class LarastatsCommandsScheduler
{
    public static function scheduleLarastatsCommands(Schedule $schedule, string $uptimeCheckCron, string $sslCertificateCheckCron)
    {
        /** @var bool $uptimeCheckIsEnabled */
        $uptimeCheckIsEnabled = config('larastats.uptime_check.enabled');
        /** @var bool $sslCheckIsEnabled */
        $sslCheckIsEnabled = config('larastats.ssl_certificate_check.enabled');

        if ($uptimeCheckIsEnabled) {
            $schedule->command(CheckUptimeCommand::class)
                ->cron($uptimeCheckCron);
        }

        if ($sslCheckIsEnabled) {
            $schedule->command(CheckSslCertificateCommand::class)
                ->cron($sslCertificateCheckCron);
        }
    }
}
