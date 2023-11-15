<?php

namespace Taecontrol\MoonGuard\Console;

use Illuminate\Console\Scheduling\Schedule;
use Taecontrol\MoonGuard\Console\Commands\CheckUptimeCommand;
use Taecontrol\MoonGuard\Console\Commands\CheckSslCertificateCommand;
use Taecontrol\MoonGuard\Console\Commands\DeleteOldExceptionCommand;

class MoonGuardCommandsScheduler
{
    public static function scheduleMoonGuardCommands(Schedule $schedule, string $uptimeCheckCron, string $sslCertificateCheckCron, string $deleteOldExceptionCron)
    {
        /** @var bool $uptimeCheckIsEnabled */
        $uptimeCheckIsEnabled = config('moonguard.uptime_check.enabled');
        /** @var bool $sslCheckIsEnabled */
        $sslCheckIsEnabled = config('moonguard.ssl_certificate_check.enabled');
        /** @var bool $deleteOldExceptionIsEnabled*/
        $deleteOldExceptionIsEnabled = config('moonguard.exception_deletion.enabled');

        if ($uptimeCheckIsEnabled) {
            $schedule->command(CheckUptimeCommand::class)
                ->cron($uptimeCheckCron);
        }

        if ($sslCheckIsEnabled) {
            $schedule->command(CheckSslCertificateCommand::class)
                ->cron($sslCertificateCheckCron);
        }

        if ($deleteOldExceptionIsEnabled) {
            $schedule->command(DeleteOldExceptionCommand::class)
                ->cron($deleteOldExceptionCron);
        }
    }
}
