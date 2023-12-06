<?php

namespace Taecontrol\MoonGuard\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class MonitoringWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $sites = SiteRepository::query()->get();
        $stats = [];

        foreach ($sites as $site) {
            $systemMetric = $site->systemMetrics()->latest()->first();
            $color = $systemMetric && $systemMetric->memory_usage > 80 ? 'danger' : 'success';
            $icon = $systemMetric && $systemMetric->memory_usage > 80 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-arrow-trending-up';
            $chart = $systemMetric && $systemMetric->memory_usage > 80 ? ([80, 95, 81, 99, 80, 92, 86]) : ([12, 32, 20, 18, 9, 60, 10]);
   
            $stats[] = Stat::make($site->name, $systemMetric ? $systemMetric->memory_usage . '%' : '0%')
                ->description('RAM')
                ->chart([[[$systemMetric ? $systemMetric->memory_usage : 0]]])
                ->color($color)
                ->descriptionIcon($icon);
            $color = $systemMetric && $systemMetric->cpu_usage > 80 ? 'danger' : 'success';
            $stats[] = Stat::make($site->name, $systemMetric ? $systemMetric->cpu_usage . '%' : '0%')
                ->description('CPU')
                ->chart([[[$systemMetric ? $systemMetric->cpu_usage : 0]]])
                ->color($color)
                ->descriptionIcon($icon);
            $color = $systemMetric && $systemMetric->disk_usage > 80 ? 'danger' : 'success';
            $stats[] = Stat::make($site->name, $systemMetric ? $systemMetric->disk_usage . '%' : '0%')
                ->description('Disk Usage')
                ->chart([[[$systemMetric ? $systemMetric->disk_usage : 0]]])
                ->color($color)
                ->descriptionIcon('heroicon-m-server');
        }
        return $stats;
    }
}
