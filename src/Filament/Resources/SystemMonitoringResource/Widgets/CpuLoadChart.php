<?php

namespace Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets;

use Livewire\Attributes\On;
use Filament\Widgets\ChartWidget;
use Taecontrol\MoonGuard\Models\SystemMetric;

class CpuLoadChart extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    public string | int | null $selectedSiteId = null;

    #[On('selected-site-changed')]
    public function updateSiteId($siteId): void
    {
        $this->selectedSiteId = $siteId;
        $this->getData();
    }

    protected function getData(): array
    {
        if ($this->selectedSiteId) {
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
