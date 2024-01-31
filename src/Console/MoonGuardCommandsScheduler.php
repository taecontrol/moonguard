<?php

namespace Taecontrol\MoonGuard\Console;

use Illuminate\Console\Scheduling\Schedule;
use Taecontrol\MoonGuard\Console\Commands\CheckUptimeCommand;
use Taecontrol\MoonGuard\Console\Commands\PruneExceptionCommand;
use Taecontrol\MoonGuard\Console\Commands\PruneServerMetricCommand;
use Taecontrol\MoonGuard\Console\Commands\CheckSslCertificateCommand;

class MoonGuardCommandsScheduler
{
    public static function scheduleMoonGuardCommands(Schedule $schedule, string $uptimeCheckCron, string $sslCertificateCheckCron, ?string $pruneOldExceptionCron = null, ?string $pruneOldServerMetricsCron = null)
    {
        /** @var bool $uptimeCheckIsEnabled */
        $uptimeCheckIsEnabled = config('moonguard.uptime_check.enabled');
        /** @var bool $sslCheckIsEnabled */
        $sslCheckIsEnabled = config('moonguard.ssl_certificate_check.enabled');
        /** @var bool $pruneOldExceptionIsEnabled */
        $pruneOldExceptionIsEnabled = config('moonguard.prune_exception.enabled');
        /** @var bool $pruneOldServerMetricsIsEnabled */
        $pruneOldServerMetricsIsEnabled = config('moonguard.prune_server_monitoring.enabled');

        if ($uptimeCheckIsEnabled) {
            $schedule->command(CheckUptimeCommand::class)
                ->cron($uptimeCheckCron);
        }

        if ($sslCheckIsEnabled) {
            $schedule->command(CheckSslCertificateCommand::class)
                ->cron($sslCertificateCheckCron);
        }

        if ($pruneOldExceptionIsEnabled && $pruneOldExceptionCron) {
            $schedule->command(PruneExceptionCommand::class)
                ->cron($pruneOldExceptionCron);
        }

        if ($pruneOldServerMetricsIsEnabled && $pruneOldServerMetricsCron) {
            $schedule->command(PruneServerMetricCommand::class)
                ->cron($pruneOldServerMetricsCron);
        }
    }
}
