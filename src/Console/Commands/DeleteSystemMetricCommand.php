<?php

namespace Taecontrol\MoonGuard\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\MoonGuard\Models\SystemMetric;

class DeleteSystemMetricCommand extends Command
{
    protected $signature = 'system-metric:delete';

    protected $description = 'Delete system metrics';

    public function handle()
    {
        if (! $this->isEnabled()) {
            $this->info('System metric deletion is disabled. If you want to enable it, check the moonguard config file.');

            return;
        }

        $this->info('Starting deletion of system metrics...');

        $time = $this->getSystemMetricAge();

        $this->info('Old system metrics deleted successfully!');

        $this->deleteOldSystemMetrics($time);
    }

    public function isEnabled(): bool
    {
        return config('moonguard.metric_deletion.enabled');
    }

    public static function getSystemMetricAge(): int
    {
        return config('moonguard.metric_deletion.delete_metrics_older_than_days');
    }

    public static function deleteOldSystemMetrics(int $time): void
    {
        $metrics = SystemMetric::query()
            ->where('recorded_at', '<', now()->subDays($time));

        $metrics->delete();
    }
}
