<?php

namespace Taecontrol\Larastats\Console;

use Illuminate\Console\Scheduling\Schedule;

class LarastatsCommandScheduler
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
            $schedule->command(CheckSslCertificate::class)
                ->cron($sslCertificateCheckCron);
        }
    }
}
