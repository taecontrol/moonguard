<?php

namespace Taecontrol\MoonGuard\Console;

use Illuminate\Console\Scheduling\Schedule;
use Taecontrol\MoonGuard\Console\Commands\CheckUptimeCommand;
use Taecontrol\MoonGuard\Console\Commands\DeleteOldExceptionCommand;
use Taecontrol\MoonGuard\Console\Commands\DeleteServerMetricCommand;
use Taecontrol\MoonGuard\Console\Commands\CheckSslCertificateCommand;

class MoonGuardCommandsScheduler
{
    public static function scheduleMoonGuardCommands(Schedule $schedule, string $uptimeCheckCron, string $sslCertificateCheckCron, ?string $deleteOldExceptionCron = null, ?string $deleteOldServerMetricsCron = null)
    {
        /** @var bool $uptimeCheckIsEnabled */
        $uptimeCheckIsEnabled = config('moonguard.uptime_check.enabled');
        /** @var bool $sslCheckIsEnabled */
        $sslCheckIsEnabled = config('moonguard.ssl_certificate_check.enabled');
        /** @var bool $deleteOldExceptionIsEnabled */
        $deleteOldExceptionIsEnabled = config('moonguard.exception_deletion.enabled');
        /** @var bool $deleteOldServerMetricsIsEnabled */
        $deleteOldServerMetricsIsEnabled = config('moonguard.system_monitoring_records_deletion.enabled');

        if ($uptimeCheckIsEnabled) {
            $schedule->command(CheckUptimeCommand::class)
                ->cron($uptimeCheckCron);
        }

        if ($sslCheckIsEnabled) {
            $schedule->command(CheckSslCertificateCommand::class)
                ->cron($sslCertificateCheckCron);
        }

        if ($deleteOldExceptionIsEnabled && $deleteOldExceptionCron) {
            $schedule->command(DeleteOldExceptionCommand::class)
                ->cron($deleteOldExceptionCron);
        }

        if ($deleteOldServerMetricsIsEnabled && $deleteOldServerMetricsCron) {
            $schedule->command(DeleteServerMetricCommand::class)
                ->cron($deleteOldServerMetricsCron);
        }
    }
}
