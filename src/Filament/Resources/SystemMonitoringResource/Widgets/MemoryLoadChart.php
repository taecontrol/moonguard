<?php

namespace Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets;

use Flowframe\Trend\Trend;
use Filament\Support\RawJs;
use Livewire\Attributes\On;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Taecontrol\MoonGuard\Models\SystemMetric;

class MemoryLoadChart extends ChartWidget
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
            $query = SystemMetric::where('site_id', $this->selectedSiteId);

            match($filter) {
                'hour' => $data = Trend::query($query)
                    ->between(start: now()->subHour(), end: now())
                    ->perMinute()
                    ->average('memory_usage'),

                'day' => $data = Trend::query($query)
                    ->between(start: now()->subDay(), end: now())
                    ->perHour()
                    ->average('memory_usage'),

                'week' => $data = Trend::query($query)
                    ->between(start: now()->subWeek(), end: now())
                    ->perDay()
                    ->average('memory_usage')
            };

            $chartData = [
                'datasets' => [
                    [
                        'label' => 'Memory Usage',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate == 0 ? null : $value->aggregate),
                        'spanGaps' => true,
                        'borderColor' => '#fcd34d',
                        'stepped' => 'middle',
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
