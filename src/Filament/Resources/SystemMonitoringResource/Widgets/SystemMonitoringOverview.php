<?php

namespace Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SystemMonitoringOverview extends BaseWidget
{
    protected $listeners = ['updateMonitoringWidget' => '$refresh'];

    protected function getStats(): array
    {
        $sites = SiteRepository::query()->get();

        if ($sites->count() <= 0) {
            return [];
        }

        $stats = [];

        foreach ($sites as $site) {
            $systemMetrics = $site->systemMetrics()->latest()->first();

            if (! $systemMetrics) {
                continue;
            }

            $cpuColor = $systemMetrics->cpu_usage > $site->cpu_limit ? 'danger' : 'success';
            $ramColor = $systemMetrics->memory_usage > $site->ram_limit ? 'danger' : 'success';
            $diskColor = $systemMetrics->disk_usage['percentage'] > $site->disk_limit ? 'danger' : 'success';

            $ramDescription = $ramColor === 'danger' ? 'Memory usage is above the limit' : 'Memory usage is stable';
            $cpuDescription = $cpuColor === 'danger' ? 'CPU usage is above the limit' : 'CPU usage is stable';
            $diskDescription = $diskColor === 'danger' ? 'Disk usage is above the limit' : 'Disk usage is stable';

            $stats[] = $this->createStat($site, $systemMetrics->memory_usage, $ramDescription, null, $ramColor);
            $stats[] = $this->createStat($site, $systemMetrics->cpu_usage, $cpuDescription, null, $cpuColor);
            $stats[] = $this->createStat($site, $systemMetrics->disk_usage['percentage'], $diskDescription, 'heroicon-m-server', $diskColor);
        }

        return $stats;
    }

    private function createStat($site, $value, $description, $icon = null, $color)
    {
        return Stat::make('Site: ' . $site->name, $value . '%')
            ->description($description)
            ->color($color)
            ->descriptionIcon($icon);
    }
}
