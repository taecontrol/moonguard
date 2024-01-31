<?php

namespace Taecontrol\MoonGuard\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\MoonGuard\Models\ServerMetric;

class PruneServerMetricCommand extends Command
{
    protected $signature = 'server-metric:prune';

    protected $description = 'Prune server metrics from sistes';

    public function handle()
    {
        if (! $this->isEnabled()) {
            $this->info('Server metric prune is disabled. If you want to enable it, check the moonguard config file.');

            return;
        }

        $this->info('Starting prune of server metrics...');

        $time = $this->getServerMetricAge();

        $this->info('Old server metrics prune successfully!');

        $this->pruneOldServerMetrics($time);
    }

    public function isEnabled(): bool
    {
        return config('moonguard.prune_server_monitoring.enabled');
    }

    public static function getServerMetricAge(): int
    {
        return config('moonguard.prune_server_monitoring.prune_server_monitoring_records_older_than_days');
    }

    public static function pruneOldServerMetrics(int $time): void
    {
        $metrics = ServerMetric::query()
            ->where('created_at', '<', now()->subDays($time));

        $metrics->delete();
    }
}
