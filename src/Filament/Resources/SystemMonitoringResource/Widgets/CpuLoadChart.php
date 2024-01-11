<?php

namespace Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets;

use Filament\Widgets\ChartWidget;
use Taecontrol\MoonGuard\Models\SystemMetric;

class CpuLoadChart extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    public ?int $selectedSiteId = null;

    public function updateSite($event): void
    {
        $this->selectedSiteId = $event['siteId'];
        $this->updateChartData();
    }

    public function updateChartData(): void
    {
        $this->getData();
    }

    protected function getListeners()
    {
        return [
            'siteChanged' => 'updateSite',
        ];
    }

    protected function getData(): array
    {
        if ($this->selectedSiteId !== null) {
            $cpuUsages = SystemMetric::where('site_id', $this->selectedSiteId)->get();

            $labels = [];

            foreach ($cpuUsages as $metric) {
                $hour = $metric->created_at->hour;
                $minute = $metric->created_at->minute;
                $labels[] = sprintf('%02d:%02d', $hour, $minute);
            }

            $chartData = [
                'datasets' => [
                    [
                        'label' => 'CPU Usage',
                        'data' => $cpuUsages->pluck('cpu_usage')->toArray(),
                    ],
                ],
                'labels' => $labels,
            ];

            return $chartData;
        }

        return [];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
