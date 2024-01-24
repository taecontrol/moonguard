<?php

namespace Taecontrol\MoonGuard\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\MoonGuard\Models\ServerMetric;

class DeleteServerMetricCommand extends Command
{
    protected $signature = 'server-metric:delete';

    protected $description = 'Delete server metrics from sistes';

    public function handle()
    {
        if (! $this->isEnabled()) {
            $this->info('Server metric deletion is disabled. If you want to enable it, check the moonguard config file.');

            return;
        }

        $this->info('Starting deletion of server metrics...');

        $time = $this->getServerMetricAge();

        $this->info('Old server metrics deleted successfully!');

        $this->deleteOldServerMetrics($time);
    }

    public function isEnabled(): bool
    {
        return config('moonguard.server_monitoring_records_deletion.enabled');
    }

    public static function getServerMetricAge(): int
    {
        return config('moonguard.server_monitoring_records_deletion.delete_server_monitoring_records_older_than_days');
    }

    public static function deleteOldServerMetrics(int $time): void
    {
        $metrics = ServerMetric::query()
            ->where('created_at', '<', now()->subDays($time));

        $metrics->delete();
    }
}
