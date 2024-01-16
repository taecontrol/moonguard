<?php

namespace Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets;

use Flowframe\Trend\Trend;
use Filament\Support\RawJs;
use Livewire\Attributes\On;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Taecontrol\MoonGuard\Models\SystemMetric;

class DiskSpaceChart extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    public string | int | null $selectedSiteId = null;

    protected static ?string $maxHeight = '300px';

    public ?string $filter = 'hour';

    #[On('selected-site-changed')]
    public function updateSiteId($siteId): void
    {
        $this->selectedSiteId = $siteId;
        $this->getData();
    }

    protected function getData(): array
    {
        if ($this->selectedSiteId) {
            $filter = $this->filter;

            $subquery = SystemMetric::selectRaw("site_id, created_at, CAST(ROUND(((JSON_EXTRACT(disk_usage, '$.totalSpace')
                - JSON_EXTRACT(disk_usage, '$.freeSpace')) / JSON_EXTRACT(disk_usage, '$.totalSpace') * 100), 2) AS DECIMAL(5,2)) AS percentage")
                ->whereColumn('site_id', 'system_metrics.site_id')
                ->whereColumn('created_at', 'system_metrics.created_at');

            $query = SystemMetric::fromSub($subquery, 'system_metrics')
                ->where('site_id', $this->selectedSiteId);

            switch ($filter) {
                case 'hour':
                    $data = Trend::query($query)
                        ->between(start: now()->subHour(), end: now())
                        ->perMinute()
                        ->average('percentage');

                    break;

                case 'day':
                    $data = Trend::query($query)
                        ->between(start: now()->subDay(), end: now())
                        ->perHour()
                        ->average('percentage');

                    break;

                case 'week':
                    $data = Trend::query($query)
                        ->between(start: now()->subWeek(), end: now())
                        ->perDay()
                        ->average('percentage');

                    break;
            }

            $chartData = [
                'datasets' => [
                    [
                        'label' => 'Disk Space Occupied',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                        'borderColor' => '#4ade80',
                        'fill' => true,
                    ],
                ],
                'labels' => $data->map(function (TrendValue $value) use ($filter) {
                    if ($filter === 'hour') {
                        [$date, $time] = explode(' ', $value->date);

                        return substr($time, 0, 5);
                    } elseif ($filter === 'day') {
                        [$date, $time] = explode(' ', $value->date);

                        return $date;
                    } else {
                        return $value->date;
                    }
                }),
            ];

            return $chartData;
        }

        return [];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'hour' => 'Last Hour',
            'day' => 'Last Day',
            'week' => 'Last Week',
        ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
        {
            scales: {
                y: {
                    ticks: {
                        callback: (value) => value + '%',
                    },
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += Math.round(context.raw) + '%';
                            return label;
                        }
                    }
                }
            }
        }
        JS);
    }
}
