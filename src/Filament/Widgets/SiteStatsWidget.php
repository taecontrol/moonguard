<?php

namespace Taecontrol\Larastats\Filament\Widgets;

use Taecontrol\Larastats\Repositories\SiteRepository;

class SiteStatsWidget extends PollableWidget
{
    protected static ?string $pollingInterval = '10s';

    protected static string $view = 'larastats::widgets.site-stats-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'sites' => SiteRepository::query()
                ->with(['uptimeCheck', 'sslCertificateCheck'])
                ->withCount(['exceptionLogs'])
                ->get(),
        ];
    }
}
