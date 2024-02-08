<?php

namespace Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Widgets;

use Flowframe\Trend\Trend;
use Filament\Support\RawJs;
use Livewire\Attributes\On;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Taecontrol\MoonGuard\Models\ServerMetric;

class DiskSpaceChart extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    public string | int | null $siteId = null;

    protected static ?string $maxHeight = '300px';

    public ?string $filter = 'hour';

    #[On('selected-site-changed')]
    public function updateSiteId($siteId): void
    {
        $this->siteId = $siteId;
        $this->getData();
    }

    public function getDescription(): ?string
    {
        return 'Time in chart displayed in UTC.';
    }

    protected function getData(): array
    {
        if ($this->siteId) {
            $filter = $this->filter;

            $subquery = ServerMetric::selectRaw("site_id, created_at, CAST(ROUND(((JSON_EXTRACT(disk_usage, '$.totalSpace')
                - JSON_EXTRACT(disk_usage, '$.freeSpace')) / JSON_EXTRACT(disk_usage, '$.totalSpace') * 100), 2) AS DECIMAL(5,2)) AS percentage")
                ->whereColumn('site_id', 'server_metrics.site_id')
                ->whereColumn('created_at', 'server_metrics.created_at');

            $query = ServerMetric::fromSub($subquery, 'server_metrics')
                ->where('site_id', $this->siteId);

            match ($filter) {
                'hour' => $data = Trend::query($query)
                    ->between(start: now()->subHour(), end: now())
                    ->perMinute()
                    ->average('percentage'),

                'day' => $data = Trend::query($query)
                    ->between(start: now()->subDay(), end: now())
                    ->perHour()
                    ->average('percentage'),

                'week' => $data = Trend::query($query)
                    ->between(start: now()->subWeek(), end: now())
                    ->perDay()
                    ->average('percentage'),
            };

            $chartData = [
                'datasets' => [
                    [
                        'label' => 'Disk Space Occupied',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate == 0 ? null : $value->aggregate),
                        'spanGaps' => true,
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

                        return $time;
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
                    min: 0,
                    max: 100,
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
