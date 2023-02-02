<?php

namespace Taecontrol\Moonguard\Console;

use Illuminate\Console\Scheduling\Schedule;
use Taecontrol\Moonguard\Console\Commands\CheckUptimeCommand;
use Taecontrol\Moonguard\Console\Commands\CheckSslCertificateCommand;

class MoonguardCommandsScheduler
{
    public static function scheduleMoonguardCommands(Schedule $schedule, string $uptimeCheckCron, string $sslCertificateCheckCron)
    {
        /** @var bool $uptimeCheckIsEnabled */
        $uptimeCheckIsEnabled = config('moonguard.uptime_check.enabled');
        /** @var bool $sslCheckIsEnabled */
        $sslCheckIsEnabled = config('moonguard.ssl_certificate_check.enabled');

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
