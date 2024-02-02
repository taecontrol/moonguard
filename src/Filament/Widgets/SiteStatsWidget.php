<?php

namespace Taecontrol\MoonGuard\Filament\Widgets;

use Taecontrol\MoonGuard\Repositories\SiteRepository;

class SiteStatsWidget extends PollableWidget
{
    protected static ?string $pollingInterval = '10s';

    protected static string $view = 'moonguard::widgets.site-stats-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'sites' => SiteRepository::query()
                ->with(['uptimeCheck', 'sslCertificateCheck', 'latestServerMetric'])
                ->withCount(['exceptionLogs' => function ($query) {
                    $query->where('status', 'unresolved');
                }])
                ->get(),
        ];
    }
}
