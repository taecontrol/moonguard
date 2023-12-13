<?php

namespace Taecontrol\MoonGuard\Filament\Resources\MonitoringResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class MonitoringOverview extends BaseWidget
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
            $systemMetric = $site->systemMetrics()->latest()->first();

            if (! $systemMetric) {
                continue;
            }

            $cpuColor = $systemMetric->cpu_usage > $site->getCpuLimit() ? 'danger' : 'success';
            $ramColor = $systemMetric->memory_usage > $site->getRamLimit() ? 'danger' : 'success';
            $diskColor = $systemMetric->disk_usage_percentage > $site->getDiskLimit() ? 'danger' : 'success';

            $ramDescription = $ramColor === 'danger' ? 'Memory usage is above the limit' : 'Memory usage is stable';
            $cpuDescription = $cpuColor === 'danger' ? 'CPU usage is above the limit' : 'CPU usage is stable';
            $diskDescription = $diskColor === 'danger' ? 'Disk usage is above the limit' : 'Disk usage is stable';

            $stats[] = $this->createStat($site, $systemMetric->memory_usage, $ramDescription, null, $ramColor);
            $stats[] = $this->createStat($site, $systemMetric->cpu_usage, $cpuDescription, null, $cpuColor);
            $stats[] = $this->createStat($site, $systemMetric->disk_usage_percentage, $diskDescription, 'heroicon-m-server', $diskColor);
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
